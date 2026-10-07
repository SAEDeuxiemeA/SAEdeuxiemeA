<?php 

    /**
     * Vue du formulaire de connexion.
     *
     * Variables fournies par le contrôleur (toutes facultatives) :
     *
     * @var string|null $error Message d'erreur d'authentification.
     * @var string|null $login Pseudo saisi, pour le réafficher après une erreur.
     */
    require_once 'header.php';
    start_page('Login', 'login');
?>
<main>
    <h1 class="sr-only">Connexion</h1>
    <?php if (!empty($error)): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?page=login&amp;action=auth">
        <div class="form-group">
            <label for="email" class="form-label">Email: </label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">MotDePasse: </label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-actions">
            <button type="submit">Se connecter</button>
            <a href="index.php?page=createacc&amp;action=index" class="btn">Je n'ai pas de compte</a>
            <a href="index.php?page=password&amp;action=index" class="btn">Mot de passe oublié ?</a>
        </div>
    </form>
</main>
<?php
    end_page();
?>