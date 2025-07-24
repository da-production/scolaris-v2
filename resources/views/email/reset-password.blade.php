<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de mot de passe</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #fff; padding: 30px; border-radius: 8px;">
        <h2 style="color: #333;">Bonjour,</h2>

        <p>Vous avez demandé à réinitialiser votre mot de passe pour votre compte sur <strong>{{ config('app.name') }}</strong>.</p>

        <p>Veuillez cliquer sur le bouton ci-dessous pour choisir un nouveau mot de passe :</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" style="background-color: #1a73e8; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px;">
                Réinitialiser le mot de passe
            </a>
        </div>

        <p>Ce lien est valable pendant 15 minutes.</p>

        <p>Si vous n'avez pas fait cette demande, vous pouvez ignorer cet e-mail.</p>

        <p >Cordialement,<br><strong>L'équipe {{ config('app.name') }}</strong></p>
    </div>
</body>
</html>
