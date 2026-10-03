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