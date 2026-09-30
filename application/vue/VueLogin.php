<?php ?><!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>
        </title>
    </head>
    <body> <?php ?>

    <form method="POST" action="">
        <div>
            <label for="Email">Email: </label>
            <input
                type="Email"
                id="Email"
                name="Email"
                required
            >
        </div>

        <div>
            <label for="password">MotDePasse: </label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <button type="submit">
            Se connecter
        </button>

        <button type="button">
            Je n'ai pas de compte
        </button>
    </form>
    </body>
</html>
