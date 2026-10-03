<?php 
    require_once 'header.php';
    start_page('Inscription');
?>
<main>
    <h1>Inscription</h1>

    <form action="inscription.php" method="post" enctype="multipart/form-data">        
        <section>
            <label for="avatar">Avatar</label>
            <input type="file" id="avatar" name="avatar" accept="image/*">        
        </section>

        <section>
            <div>
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo">
            </div>

            <div>
                <label for="email">Adresse e-mail</label>
                <input type="email" name="email">
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password">
            </div>

            <div>
                <label for="password_confirm">Confirmation du mot de passe</label>
                <input type="password" name="password_confirm">
            </div>
        </section>

        <div>
            <button>Je m'inscris</button>
            <a href="connexion.php" class = "btn">J'ai déjà un compte</a>        
        </div>
    </form>
</main>
<?php
    end_page();
?>