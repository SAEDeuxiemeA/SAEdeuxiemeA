<?php
    function start_page($title, $css_page = null) : void //cette fonction permet de ne pas réécrire le head et header dans chaque vue. Elle est appelée dans chaque vue.
    {
?><!DOCTYPE html>
<html lang="fr"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="icon" type="image/x-icon" href="../../favicon.ico"> <!--ajout du favicon sur toutes les pages--> 

    <link rel="stylesheet" href="application/CSS/global.css"> <!--lien vers le CSS global à toutes les vues-->
    <?php if ($css_page): ?>
        <link rel="stylesheet" href="application/CSS/<?php echo $css_page; ?>.css"> <!--lien vers le CSS spécialement pour cette vue-->
    <?php endif; ?>
</head> 
<body> 
    <header> <!--dans ce header, on y met les boutons qui vont apparaître sur chacune des pages-->
        <ul class="header-top">
            <li class="header-left">
                <p class="logo">logo</p>
                <button>?</button>
                <button>M</button>
            </li>
            <li class="header-center">
                <strong>TECHDLE</strong> <!--titre de notre jeu-->
            </li>
            <li class="header-right">
                <button>Parametre</button>
                <button>Classement</button>
                <button>Social</button>
                <button>Profil</button>
            </li>
        </ul>
        <nav class="header-nav"> <!--permet la navigation sur le site et l'accés aux pages-->
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
    function end_page() : void //tout comme start_page, cette fonction permet de ne pas se répéter dans chaque vue
    {
?>
</body>
</html>
<?php
    }
?>