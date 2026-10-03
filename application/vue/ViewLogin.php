<?php 
    require_once 'header.php';
    start_page('Login');
?>
<main>
    <h1>Connexion</h1>
    <form method="POST" action="">
        <div>
            <label for="email">Email: </label>
            <input type="email" id="email" name="email">
        </div>

        <div>
            <label for="password">MotDePasse: </label>
            <input type="password" id="password" name="password">
        </div>

        <div>
            <button type="submit">Se connecter</button>
            <a href="inscription.php" class="btn">Je n'ai pas de compte</a>        </div>
    </form>
</main>
<?php
    end_page();
?>