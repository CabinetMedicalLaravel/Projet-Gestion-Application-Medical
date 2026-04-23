@component('mail::message')
# Rendez-vous annulé

Bonjour {{ $appointment->patient->name ?? 'Cher patient' }},

Nous vous informons que votre rendez-vous du **{{ $appointment->appointment_date->format('d/m/Y à H:i') }}**
a été **annulé automatiquement** car il n'a pas été confirmé et la date est dépassée de plus d'une heure.

Si vous souhaitez reprendre un rendez-vous, vous pouvez le faire directement depuis notre plateforme.

Merci de votre compréhension.

Cordialement,
**L'équipe {{ config('app.name') }}**
@endcomponent