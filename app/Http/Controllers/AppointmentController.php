<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Mail\RdvConfirmeMail;
use App\Models\Creneau;
use App\Services\SlotGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    protected $slotService;

    public function __construct(SlotGeneratorService $slotService)
    {
        $this->slotService = $slotService;
    }

    private function generateDoctorSlots($doctorId, $date)
    {
        return $this->slotService->generate($doctorId, $date);
    }

    // ── 1. CALENDRIER ────────────────────────────────────────────────────
    public function calendrier(Request $request)
    {
        $medecins = User::where('role', 'medecin')->get();
        $doctorId = $request->get('doctor_id', $medecins->first()?->id);
        $medecin  = User::find($doctorId);
        $mois     = $request->get('mois', now()->format('Y-m'));
        $debut    = Carbon::parse($mois . '-01');
        $fin      = $debut->copy()->endOfMonth();

        $calendar = [];
        $cursor   = $debut->copy();
        while ($cursor <= $fin) {
            if ($cursor->isWeekday()) {
                $dateStr = $cursor->toDateString();
                $pris = Appointment::where('doctor_id', $doctorId)
                    ->whereDate('appointment_date', $dateStr)
                    ->whereIn('status', ['en_attente', 'confirme'])
                    ->pluck('appointment_date')
                    ->map(fn($d) => Carbon::parse($d)->format('H:i'))
                    ->toArray();

                $availableSlots = $this->generateDoctorSlots($doctorId, $dateStr);

                $calendar[$dateStr] = array_map(fn($c) => [
                    'heure'      => $c,
                    'disponible' => !in_array($c, $pris),
                ], $availableSlots);
            }
            $cursor->addDay();
        }

        return view('rdv.calendrier', compact('medecins', 'medecin', 'calendar', 'mois', 'debut', 'doctorId'));
    }

    // ── 2. PRENDRE RDV (patient) ─────────────────────────────────────────
    public function create(Request $request)
    {
        $medecins         = User::where('role', 'medecin')->get();
        $doctorId         = $request->get('doctor_id');
        $date             = $request->get('date', now()->addDay()->format('Y-m-d'));
        $preselectedHeure = $request->get('heure');

        $creneauxDisponibles = [];
        if ($doctorId && $date) {
            $pris = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $date)
                ->whereIn('status', ['en_attente', 'confirme'])
                ->pluck('appointment_date')
                ->map(fn($d) => Carbon::parse($d)->format('H:i'))
                ->toArray();
            $availableSlots = $this->generateDoctorSlots($doctorId, $date);
            $creneauxDisponibles = array_values(array_filter($availableSlots, fn($c) => !in_array($c, $pris)));
        }

        return view('rdv.prendre', compact('medecins', 'creneauxDisponibles', 'doctorId', 'date', 'preselectedHeure'));
    }

    public function store(Request $request)
    {
        $isSecretaire = Auth::user()->role === 'secretaire';

        $rules = [
            'doctor_id' => 'required|exists:users,id',
            'date'      => $isSecretaire ? 'required|date|after_or_equal:today' : 'required|date|after:today',
            'heure'     => 'required',
            'reason'    => 'required|string|max:500',
        ];

        // Secrétaire must provide patient name (no account needed)
        if ($isSecretaire) {
            $rules['patient_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $appointmentDate = Carbon::parse($request->date . ' ' . $request->heure);

        // Prevent double booking
        $existe = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDate)
            ->whereIn('status', ['en_attente', 'confirme'])
            ->exists();

        if ($existe) {
            return back()->withErrors(['heure' => 'Ce créneau vient d\'être pris. Veuillez en choisir un autre.'])->withInput();
        }

        if (!$isSecretaire) {
            $patientDejaPris = Appointment::where('patient_id', Auth::id())
                ->where('appointment_date', $appointmentDate)
                ->whereIn('status', ['en_attente', 'confirme'])
                ->exists();
            if ($patientDejaPris) {
                return back()->withErrors(['heure' => 'Vous avez déjà un rendez-vous à cette heure.'])->withInput();
            }
        }

        Appointment::create([
            'patient_id'       => $isSecretaire
                ? optional(User::where('role', 'patient')->where('name', $request->patient_name)->first())->id
                : Auth::id(),
            'patient_name'     => $isSecretaire ? $request->patient_name : null,
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $appointmentDate,
            'reason'           => $request->reason,
            'status'           => $isSecretaire ? 'confirme' : 'en_attente',
        ]);

        return redirect()->route($isSecretaire ? 'secretaire.dashboard' : 'rdv.mes-rdv')
            ->with('success', $isSecretaire
                ? 'Rendez-vous créé et confirmé pour ' . $request->patient_name . '.'
                : 'Votre rendez-vous a été enregistré avec succès !');
    }

    // ── 3. MES RDV (patient) ─────────────────────────────────────────────
    public function index()
    {
        // Auto-expire past pending appointments
        Appointment::where('patient_id', Auth::id())
            ->where('status', 'en_attente')
            ->where('appointment_date', '<', Carbon::now())
            ->update(['status' => 'annule']);

        $rdvs = Appointment::with(['patient', 'doctor'])
            ->where('patient_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('rdv.mes-rdv', compact('rdvs'));
    }

    // ── 4. MODIFIER RDV ──────────────────────────────────────────────────
    public function edit(Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        abort_if(in_array($appointment->status, ['annule', 'termine']), 403);

        $date = Carbon::parse($appointment->appointment_date)->format('Y-m-d');
        $pris = Appointment::where('doctor_id', $appointment->doctor_id)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['en_attente', 'confirme'])
            ->where('id', '!=', $appointment->id)
            ->pluck('appointment_date')
            ->map(fn($d) => Carbon::parse($d)->format('H:i'))
            ->toArray();

        $availableSlots = $this->generateDoctorSlots($appointment->doctor_id, $date);
        $creneauxDisponibles = array_values(array_filter($availableSlots, fn($c) => !in_array($c, $pris)));
        $medecins = User::where('role', 'medecin')->get();

        return view('rdv.modifier', compact('appointment', 'medecins', 'creneauxDisponibles', 'date'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);

        $request->validate([
            'date'   => 'required|date|after:today',
            'heure'  => 'required',
            'reason' => 'required|string|max:500',
        ]);

        $newDate = Carbon::parse($request->date . ' ' . $request->heure);

        $existe = Appointment::where('doctor_id', $appointment->doctor_id)
            ->where('appointment_date', $newDate)
            ->where('id', '!=', $appointment->id)
            ->whereIn('status', ['en_attente', 'confirme'])
            ->exists();

        if ($existe) {
            return back()->withErrors(['heure' => 'Ce créneau est déjà pris.'])->withInput();
        }

        $appointment->update([
            'appointment_date' => $newDate,
            'reason'           => $request->reason,
            'status'           => 'en_attente',
        ]);

        return redirect()->route('rdv.mes-rdv')->with('success', 'Rendez-vous modifié avec succès.');
    }

    public function annuler(Appointment $appointment)
    {
        $user = Auth::user();

        if ($user->role === 'patient') {
            abort_if($appointment->patient_id !== $user->id, 403);
        }

        // Médecin/secrétaire cannot cancel if RDV is less than 24h away
        if (in_array($user->role, ['medecin', 'secretaire'])) {
            if (!$appointment->canBeCancelledByStaff()) {
                return back()->with('error', 'Impossible d\'annuler un rendez-vous à moins de 24h. Veuillez contacter le patient directement.');
            }
        }

        $appointment->update(['status' => 'annule']);

        $route = match($user->role) {
            'medecin'    => 'medecin.agenda',
            'secretaire' => 'secretaire.dashboard',
            default      => 'rdv.mes-rdv',
        };

        return redirect()->route($route)->with('success', 'Rendez-vous annulé.');
    }

    // ── 5. PLANNING ──────────────────────────────────────────────────────
    public function planning(Request $request)
    {
        $user = Auth::user();
        abort_if(!in_array($user->role, ['medecin', 'secretaire']), 403);

        $vue  = $request->get('vue', 'jour');
        $date = Carbon::parse($request->get('date', now()->toDateString()));

        $query = Appointment::with(['patient', 'doctor']);

        if ($user->role === 'medecin') {
            $query->where('doctor_id', $user->id);
        }

        if ($vue === 'semaine') {
            $debut = $date->copy()->startOfWeek();
            $fin   = $date->copy()->endOfWeek();
            $rdvs  = $query->whereBetween('appointment_date', [$debut->startOfDay(), $fin->endOfDay()])
                ->orderBy('appointment_date')
                ->get()
                ->groupBy(fn($r) => Carbon::parse($r->appointment_date)->toDateString());
        } else {
            $rdvs = $query->whereDate('appointment_date', $date)
                ->orderBy('appointment_date')
                ->get();
        }

        return view('rdv.planning', compact('rdvs', 'vue', 'date'));
    }

    // ── 6. UPDATE STATUS (médecin / secrétaire) ──────────────────────────
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $user   = Auth::user();
        $status = $request->validate(['status' => 'required|in:confirme,annule,termine'])['status'];

        if ($user->role === 'patient') {
            return back()->with('error', 'Action non autorisée.');
        }

        // Cannot cancel if < 24h away (staff rule)
        if ($status === 'annule' && in_array($user->role, ['medecin', 'secretaire'])) {
            if (!$appointment->canBeCancelledByStaff()) {
                return back()->with('error', 'Impossible d\'annuler à moins de 24h du rendez-vous.');
            }
        }

        // Cannot mark as "terminé" before the appointment time
        if ($status === 'termine' && !$appointment->canBeMarkedDone()) {
            return back()->with('error', 'Impossible de terminer un rendez-vous avant son heure prévue.');
        }

        $appointment->update(['status' => $status]);

        // Send confirmation email when status changes to "confirme"
        if ($status === 'confirme') {
            $email = $appointment->patient?->email;
            if ($email) {
                try {
                    Mail::to($email)->send(new RdvConfirmeMail($appointment));
                } catch (\Exception $e) {
                    // Log but don't fail the request
                    \Log::warning('RDV confirmation email failed: ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    // ── 7. SECRÉTAIRE: créer RDV pour un patient ─────────────────────────
    public function createForPatient(Request $request)
    {
        abort_if(Auth::user()->role !== 'secretaire', 403);

        $medecins         = User::where('role', 'medecin')->get();
        $patients         = User::where('role', 'patient')->orderBy('name')->get();
        $doctorId         = $request->get('doctor_id');
        $date             = $request->get('date', now()->addDay()->format('Y-m-d'));
        $preselectedHeure = $request->get('heure');

        $creneauxDisponibles = [];
        if ($doctorId && $date) {
            $pris = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $date)
                ->whereIn('status', ['en_attente', 'confirme'])
                ->pluck('appointment_date')
                ->map(fn($d) => Carbon::parse($d)->format('H:i'))
                ->toArray();
            $availableSlots = $this->generateDoctorSlots($doctorId, $date);
            $creneauxDisponibles = array_values(array_filter($availableSlots, fn($c) => !in_array($c, $pris)));
        }

        return view('rdv.prendre-secretaire', compact('medecins', 'patients', 'creneauxDisponibles', 'doctorId', 'date', 'preselectedHeure'));
    }
}
