<?php 
    require_once 'header.php';
    start_page('Password', 'mdp');
?>
<main>
    <form method="POST" action="">
        <div class="form-group">
            <label for="newPassword">Nouveau mot de passe :</label>
            <input
                    type="password" id="newPassword" name="newPassword">
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirmation du mot de passe :</label>
            <input type="password" id="confirmPassword" name="confirmPassword">
        </div>

        <div class="form-actions">
            <button type="submit">Changer votre mot de passe</button>
        </div>
    </form>
</main>
<?php
    end_page();
?>