<?php
    require_once 'header.php';
    start_page('setting', 'Setting');
?>
<main>
    <section>
        <div>
            <label>Volume</label>
            <input type="range" id="volume" name="volume" min="0" max="100">
        </div>  
        <div>
            <label>Clavier</label>
            <select name="clavier" id="clavier">
                <option value="Azerty">Azerty</option>
                <option value="Beto">Beto</option>
                <option value="Qwerty">Qwerty</option>
            </select>
        </div>
        <div>
            <label>Mode</label>
            <select name="mode" id="mode">
                <option value="Clair">Clair</option>
                <option value="Sombre">Sombre</option>
                <option value="Daltonien">Daltonien</option>
            </select>
        </div>
    </section>

    <section>
        <h2>Thème</h2> 
        <ul>
            <li>Thème 1</li>
            <li>Thème 2</li>
            <li>Thème 3</li>
            <li>Thème 4</li>
            <li>Thème 5</li>
        </ul>
        <h2>Niveaux</h2>
        <ul>
            <li>5 lettres</li>
            <li>6 lettres</li>
            <li>7 lettres</li>
            <li>8 lettres</li>
        </ul>
    </section>

    <a href="index.php?page=login&amp;action=index">Log In</a>
    <a href="index.php?page=login&amp;action=logout">Log Out</a>
</main>
<?php
    end_page();
?>