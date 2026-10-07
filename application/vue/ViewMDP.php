<?php 

    /**
     * Vue du formulaire « mot de passe oublié ».
     *
     * Variables fournies par le contrôleur (toutes facultatives) :
     *
     * @var string|null $email   Adresse e-mail saisie.
     * @var string|null $message Message de confirmation d'envoi.
     * @var string|null $error   Message d'erreur (lien invalide ou expiré).
     */

    require_once 'header.php';
    start_page('Password', 'mdp');
?>
<main>
    <h1>Mot de passe oublié</h1>
    <form method="POST" action="index.php?page=password&amp;action=send"> <!--formulaire pour pouvoir changer de mot de passe-->
        <section class="form-body">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required>        </section>

        <div class="form-actions">
            <button type="submit">Changer votre mot de passe</button>
            <a href="index.php?page=reset&amp;action=index">Reset</a> <!--bouton qui nous renvoie sur la page reset-->
        </div>
    </form>
</main>
<?php
    end_page();
?>