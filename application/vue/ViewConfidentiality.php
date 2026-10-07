<?php 

    /**
     * Vue de la page de politique de confidentialité.
     *
     * Page statique : aucune variable n'est attendue du contrôleur.
     * Contenu : responsable du traitement, données collectées, finalités,
     * base légale, durée de conservation, partage, cookies et droits des
     * utilisateurs (RGPD).
     */

    require_once 'header.php';
    start_page('Confidentialite', 'confidentiality');
?>
<main>
    <h1>Politique de confidentialité</h1>

    <p>
        Cette page explique comment vos données personnelles sont collectées
        et utilisées sur ce site, conformément au Règlement Général sur la
        Protection des Données (RGPD).
    </p>

    <h2>Responsable du traitement</h2>
    <p>
        Anna BOIN, Mélissa BULUT, Tommy LI, Ombeline CHAUD, Kalvin DURAN<br>
        413 Av. Gaston Berger, 13100 Aix-en-Provence<br>
        contact@exemple.fr
    </p>

    <h2>Données collectées</h2>
    <p>Nous pouvons collecter les données suivantes :</p>
    <ul>
        <li>Données d'identification : adresse email</li>
        <li>Données de connexion : adresse IP, type de navigateur, pages consultées</li>
    </ul>

    <h2>Finalités du traitement</h2>
    <p>Vos données sont utilisées pour :</p>
    <ul>
        <li>Répondre à vos demandes de contact</li>
        <li>Gérer votre compte utilisateur</li>
        <li>Améliorer le fonctionnement et la sécurité du site</li>
    </ul>

    <h2>Base légale</h2>
    <p>
        Le traitement de vos données repose sur votre consentement
        ou sur l'exécution d'un service que vous avez demandé.
    </p>

    <h2>Durée de conservation</h2>
    <p>
        Vos données sont conservées uniquement le temps nécessaire aux finalités
        ci-dessus, puis supprimées ou anonymisées.
    </p>

    <h2>Partage des données</h2>
    <p>
        Vos données ne sont ni vendues ni cédées à des tiers. Elles peuvent être
        transmises à notre hébergeur, uniquement pour assurer le fonctionnement du site.
    </p>

    <h2>Cookies</h2>
    <p>
        Ce site utilise des cookies strictement nécessaires à son fonctionnement
        (par exemple pour la session de connexion). Aucun cookie publicitaire
        n'est déposé sans votre accord.
    </p>

    <h2>Vos droits</h2>
    <p>Vous disposez des droits suivants sur vos données :</p>
    <ul>
        <li>Droit d'accès</li>
        <li>Droit de rectification</li>
        <li>Droit à l'effacement</li>
        <li>Droit d'opposition et de limitation du traitement</li>
        <li>Droit à la portabilité</li>
    </ul>
    <p>
        Pour exercer ces droits, contactez-nous à contact@exemple.fr.
        Vous pouvez aussi introduire une réclamation auprès de la
        <a href="https://www.cnil.fr" target="_blank" rel="noopener">CNIL</a>.
    </p>
</main>
<?php 
    end_page();
?>