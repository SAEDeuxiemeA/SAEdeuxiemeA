<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer le mot de passe</title>
</head>

<body>

<form method="POST" action="">
    <div>
        <label for="newPassword">Nouveau mot de passe :</label>
        <input
                type="password"
                id="newPassword"
                name="newPassword"
                required
        >
    </div>

    <div>
        <label for="confirmPassword">Confirmation du mot de passe :</label>
        <input
                type="password"
                id="confirmPassword"
                name="confirmPassword"
                required
        >
    </div>

    <button type="submit">
        Changer votre mot de passe
    </button>
</form>

</body>
</html>