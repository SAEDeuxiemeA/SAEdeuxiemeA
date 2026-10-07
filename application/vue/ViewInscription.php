<?php 
    require_once 'header.php';

    start_page('Inscription', 'inscription');
    $errors = $errors ?? [];
?>
<main>
    <h1 class="sr-only">Inscription</h1>

    <?php if (!empty($errors['general'])): ?>
        <p role="alert"><?= htmlspecialchars($errors['general'], ENT_QUOTES, 'UTF-8') ?></p>    
    <?php endif; ?>

    <form action="index.php?page=createacc&amp;action=register" method="post"> <!--Crée un formulaire pour s'inscrire-->
        <section class="form-body">
            <label for="login" class="form-label">Pseudo</label>
            <input type="text" id="login" name="login" maxlength="25" value="<?= htmlspecialchars($login ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required>


            <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>
        </section>


        <div class="form-actions">
            <button type="submit">Je m'inscris</button>
            <a href="index.php?page=login&amp;action=index" class="btn">J'ai déjà un compte</a> <!--bouton qui nous renvoie à la page login-->
        </div>
    </form>
</main>

<?php
    end_page();
?>