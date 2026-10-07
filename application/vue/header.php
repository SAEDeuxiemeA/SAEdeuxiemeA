<?php
    /**
     * Fonctions communes d'en-tête et de pied de page des vues.
     *
     * Chaque vue appelle start_page() au début et end_page() à la fin.
     */
 
    /**
     * Affiche le début de la page : doctype, `<head>`, feuilles de style,
     * bandeau d'en-tête et menu de navigation.
     *
     * @param string      $title    Titre de la page (balise `<title>`).
     * @param string|null $css_page Nom (sans extension) du fichier CSS propre à la page,
     *                              situé dans `application/CSS/`. Null pour n'utiliser que `global.css`.
    */

    function start_page($title, $css_page = null) : void 
    {
?><!DOCTYPE html>
<html lang="fr"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">

    <link rel="stylesheet" href="application/CSS/global.css">
    <?php if ($css_page): ?>
        <link rel="stylesheet" href="application/CSS/<?php echo $css_page; ?>.css">
    <?php endif; ?>
</head> 
<body> 
    <header>
        <ul class="header-top">
            <li class="header-left">
                <p class="logo">logo</p>
                <button>?</button>
                <button>M</button>
            </li>
            <li class="header-center">
                <strong>TECHDLE</strong>
            </li>
            <li class="header-right">
                <button>Parametre</button>
                <button>Classement</button>
                <button>Social</button>
                <button>Profil</button>
            </li>
        </ul>
        <nav class="header-nav">
        <ul>
            <li><a href="index.php?page=home&amp;action=index">Home</a></li>
            <li><a href="index.php?page=password&amp;action=index">Forgot your password?</a></li>
            <li><a href="index.php?page=legal&amp;action=index">Legal notice</a></li>
            <li><a href="index.php?page=confidentiality&amp;action=index">Confidentiality</a></li>
            <?php if (isset($_SESSION['login'])): ?>
                <li><a href="index.php?page=login&amp;action=logout">Log Out</a></li>
            <?php else: ?>
                <li><a href="index.php?page=login&amp;action=index">Log In</a></li>
                <li><a href="index.php?page=createacc&amp;action=index">Create an account</a></li>
            <?php endif; ?>
        </ul>
        </nav>
    </header>
<?php 
    } 
?>

<?php

    /**
     * Affiche la fin de la page : ferme les balises `<body>` et `<html>`.
     *
     * @return void
     */
    function end_page() : void
    {
?>
</body>
</html>
<?php
    }
?>