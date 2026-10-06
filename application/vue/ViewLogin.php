<?php 
    require_once 'header.php';
    start_page('Login', 'login');
?>
<main>
    <h1 class="sr-only">Connexion</h1>
    <form method="POST" action="index.php?page=login&amp;action=login">
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
        </div>
    </form>
</main>
<?php
    end_page();
?>