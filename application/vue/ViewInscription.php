<?php 
    require_once 'header.php';
    start_page('Inscription');
    $errors = $errors ?? [];
?>
<main>
    <h1>Inscription</h1>

    <?php if (!empty($errors['general'])): ?>
        <p role="alert"><?= $errors['general'] ?></p>
    <?php endif; ?>

    <form action="index.php?page=createacc&amp;action=register" method="post" enctype="multipart/form-data">
        <section>
            <label for="login">Pseudo</label>
            <input type="text" id="login" name="login" maxlength="25" value="<?= $login ?? '' ?>" required>


            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="<?= $email ?? '' ?>" required>


            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required>


            <label for="password_confirm">Confirmation du mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>
        </section>

        <div>
            <button type="submit">Je m'inscris</button>
            <a href="index.php?page=login&amp;action=index" class = "btn">J'ai déjà un compte</a>
        </div>
    </form>
</main>

<?php
    end_page();
?>