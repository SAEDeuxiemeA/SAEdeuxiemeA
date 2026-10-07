<?php

    /**
     * Vue du formulaire de nouveau mot de passe.
     *
     * Variables fournies par le contrôleur (toutes facultatives) :
     *
     * @var string|null $token Jeton de réinitialisation, renvoyé dans un champ caché.
     * @var string|null $error Message d'erreur de validation.
     */

    require_once __DIR__ . '/header.php';
    start_page('Nouveau mot de passe', 'reset');
?>
    <main>
        <?php if (!empty($error)): ?>
            <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <p role="status"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="index.php?page=password&amp;action=updatePassword" method="post"> <!--formulaire pour changer de mot de passe-->
            <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <div class="form-group">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" minlength="8" required>
                </div>      

                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirmation</label>
                    <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>
                </div>
            <div class="form-action">
                <button type="submit" class="form-actions">Changer le mot de passe</button>
            </div>
        </form>
    </main>
<?php 
    end_page();
?>