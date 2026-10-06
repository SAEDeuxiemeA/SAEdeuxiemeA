<?php 
    require_once 'header.php';
    start_page('Password', 'mdp');
?>
<main>
    <h1>Mot de passe oublié</h1>
    <form method="POST" action="index.php?page=password&amp;action=send">
        <section class="form-body">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required>        </section>

        <div class="form-actions">
            <button type="submit">Changer votre mot de passe</button>
            <a href="index.php?page=reset&amp;action=index">Reset</a>
        </div>
    </form>
</main>
<?php
    end_page();
?>