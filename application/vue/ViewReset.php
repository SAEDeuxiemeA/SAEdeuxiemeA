<?php
require_once __DIR__ . '/header.php';
start_page('Nouveau mot de passe');
?>
    <main>
        <h1>Nouveau mot de passe</h1>

        <?php if (!empty($error)): ?><p role="alert"><?= $error ?></p><?php endif; ?>

        <form action="index.php?page=password&amp;action=update" method="post">
            <input type="hidden" name="token" value="<?= $token ?? ''?>">

            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required>

            <label for="password_confirm">Confirmation</label>
            <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>

            <button type="submit">Changer le mot de passe</button>
        </form>
    </main>
<?php end_page();