<?php
    function start_page($title) : void 
    {
?><!DOCTYPE html>
<html lang="fr"> 
<head> 
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">
</head> 
<body> 
    <header>
        <ul>
            <li>
                <p>logo</p>
                <button>?</button>
                <button>M</button>
            </li>
            <li>
                <strong>TECHDLE</strong>
            </li>
            <li>
                <button>Parametre</button>
                <button>Classement</button>
                <button>Social</button>
                <button>Profil</button>
            </li>
        </ul>
        <nav>
        <ul>
            <li><a href="index.php?page=home&amp;action=index">Home</a></li>
            <li><a href="index.php?page=login&amp;action=index">Log in</a></li>
            <li><a href="index.php?page=createacc&amp;action=index">Create an account</a></li>
            <li><a href="index.php?page=password&amp;action=index">Forgot your password?</a></li>
            <li><a href="index.php?page=legal&amp;action=index">Legal notice</a></li>
            <li><a href="index.php?page=confidentiality&amp;action=index">Confidentiality</a></li>
        </ul>
        </nav>
    </header>
<?php 
    } 
?>

<?php
    function end_page() : void
    {
?>
</body>
</html>
<?php
    }
?>