<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rendez-vous confirmé</title>
<style>
  body { margin: 0; padding: 0; background: #f4f8fb; font-family: 'Segoe UI', Arial, sans-serif; color: #1f2937; }
  .wrap { max-width: 580px; margin: 40px auto; background: white; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: linear-gradient(135deg, #1976D2, #0D47A1); padding: 36px 40px; text-align: center; }
  .header h1 { color: white; margin: 0; font-size: 22px; font-weight: 600; letter-spacing: -.3px; }
  .header p { color: rgba(255,255,255,.8); margin: 8px 0 0; font-size: 13px; }
  .check { width: 56px; height: 56px; background: rgba(255,255,255,.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
  .body { padding: 36px 40px; }
  .greeting { font-size: 16px; margin-bottom: 20px; }
  .rdv-card { background: #f4f8fb; border-radius: 12px; padding: 20px 24px; margin: 20px 0; border-left: 4px solid #1976D2; }
  .rdv-row { display: flex; gap: 12px; align-items: center; margin-bottom: 12px; font-size: 14px; }
  .rdv-row:last-child { margin-bottom: 0; }
  .rdv-row .icon { width: 32px; height: 32px; background: #1976D215; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .rdv-label { font-size: 11px; color: #6b7280; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
  .rdv-value { font-weight: 600; color: #111; }
  .info-box { background: #fff7ed; border-radius: 10px; padding: 14px 18px; font-size: 13px; color: #92400e; margin-top: 20px; }
  .footer { padding: 24px 40px; border-top: 1px solid #f0f0f0; text-align: center; font-size: 12px; color: #9ca3af; }
  .btn { display: inline-block; background: linear-gradient(135deg, #1976D2, #0D47A1); color: white; text-decoration: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; margin-top: 24px; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="check">
      <svg width="28" height="28" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <h1>Rendez-vous confirmé !</h1>
    <p>Votre consultation a été validée par le médecin</p>
  </div>

  <div class="body">
    <p class="greeting">Bonjour <strong>{{ $appointment->patient_display_name }}</strong>,</p>
    <p style="font-size:14px; color:#6b7280; line-height:1.6;">
      Votre rendez-vous a été <strong style="color:#059669;">confirmé</strong>. Voici le récapitulatif de votre consultation :
    </p>

    <div class="rdv-card">
      <div class="rdv-row">
        <div class="icon">
          <svg width="16" height="16" fill="none" stroke="#1976D2" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div>
          <div class="rdv-label">Date & heure</div>
          <div class="rdv-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('l d F Y \à H:i') }}</div>
        </div>
      </div>
      <div class="rdv-row">
        <div class="icon">
          <svg width="16" height="16" fill="none" stroke="#1976D2" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
          <div class="rdv-label">Médecin</div>
          <div class="rdv-value">Dr. {{ $appointment->doctor->name }}</div>
        </div>
      </div>
      @if($appointment->reason)
      <div class="rdv-row">
        <div class="icon">
          <svg width="16" height="16" fill="none" stroke="#1976D2" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
          <div class="rdv-label">Motif</div>
          <div class="rdv-value" style="font-weight:400; font-style:italic;">{{ $appointment->reason }}</div>
        </div>
      </div>
      @endif
    </div>

    <div class="info-box">
      ⏰ <strong>Rappel :</strong> Merci d'arriver 10 minutes avant votre rendez-vous. En cas d'empêchement, veuillez annuler au moins 24h à l'avance.
    </div>
  </div>

  <div class="footer">
    <p>{{ config('app.name') }} — Cabinet Médical</p>
    <p style="margin-top:4px;">Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
  </div>
</div>
</body>
</html>
