<?php 
    require_once 'header.php';
    start_page('Password');
?>
<main>
    <form method="POST" action="">
        <div>
            <label for="newPassword">Nouveau mot de passe :</label>
            <input
                    type="password" id="newPassword" name="newPassword">
        </div>

        <div>
            <label for="confirmPassword">Confirmation du mot de passe :</label>
            <input type="password" id="confirmPassword" name="confirmPassword">
        </div>

        <button type="submit">Changer votre mot de passe</button>
    </form>
</main>
<?php
    end_page();
?>