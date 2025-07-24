<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Code de vérification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Bonjour,</h2>

        <p>Voici votre code de vérification :</p>

        <div style="font-size: 24px; font-weight: bold; color: #1a73e8; text-align: center; margin: 20px 0;">
            {{ $otp }}
        </div>

        <p>Ce code est valable pendant 10 minutes. Ne le partagez avec personne.</p>

        <p>Si vous n'avez pas demandé ce code, vous pouvez ignorer cet e-mail.</p>
        

        <p>Cordialement,<br><strong>L’équipe {{ config('app.name') }}</strong></p>
    </div>
</body>
</html>
