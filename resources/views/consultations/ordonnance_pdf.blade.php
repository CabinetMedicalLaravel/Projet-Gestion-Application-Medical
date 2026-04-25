<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ordonnance Médicale</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 30px; }
        .header { text-align: center; border-bottom: 2px solid #1e293b; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1e293b; text-transform: uppercase; letter-spacing: 2px; }
        
        .info { margin-top: 40px; }
        .info p { margin: 5px 0; }
        
        .prescription { margin-top: 50px; min-height: 300px; }
        .prescription h3 { border-bottom: 1px solid #eee; pb: 5px; color: #1e293b; }
        .medicaments { font-size: 18px; line-height: 1.8; margin-top: 20px; white-space: pre-wrap; }
        
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; border-top: 1px solid #eee; display: inline-block; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CABINET MÉDICAL</h1>
        <p><strong>Dr. {{ Auth::user()->name }}</strong><br>Docteur en Médecine</p>
    </div>

    <div class="info">
        <p style="float: right;"><strong>Date :</strong> {{ date('d/m/Y') }}</p>
        <p><strong>Patient :</strong> {{ $consultation->patient->name ?? 'Patient' }}</p>
    </div>

    <div class="prescription">
        <h3>ORDONNANCE</h3>
        <div class="medicaments">
            {{-- Utilise la variable directe de la consultation si l'ordonnance n'est pas une table séparée --}}
            {!! nl2br(e($consultation->traitement)) !!}
            {!! nl2br(e($consultation->medicaments)) !!}
        </div>
    </div>

    <div class="footer">
        <div class="signature">
            Signature et cachet du médecin
        </div>
    </div>
</body>
</html>