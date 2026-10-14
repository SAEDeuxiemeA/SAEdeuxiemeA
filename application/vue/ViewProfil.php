<?php
    require_once 'header.php';
    start_page('Profil', 'Profil');
?>
<main>
    <section>
       <p>Avatar</p> 
    </section>
    <section>
        <label for="Pseudo">Pseudo</label><br>
        <label for="Meilleure série">Meilleure Série</label><br>
        <label for="Taux de réussite">Taux de réussite</label><br>
        <label for="Nombre de duels gagnés">Nombre de duels gagnés</label><br>
        <label for="Rang">Rang</label>
    </section>

    <ul>
        <li>BADGE</li>
        <li>BADGE</li>
        <li>BADGE</li>
        <li>BADGE</li>
        <li>BADGE</li>
        <li>BADGE</li>
    </ul>

    <button type="submit">Se déconnecter</button>
</main>
<?php
    end_page();
?>