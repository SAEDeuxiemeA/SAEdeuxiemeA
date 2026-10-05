<?php 
    require_once 'header.php';
    start_page('Password', 'mdp');
?>
<main>
    <h1>Mot de passe oublié</h1>
    <form method="POST" action="">
        <section class="form-body">
            <label for="email" class="form label">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="<?= $email ?? '' ?>" required>
        </section>

        <div class="form-actions">
            <button type="submit">Changer votre mot de passe</button>
        </div>
    </form>
</main>
<?php
    end_page();
?>