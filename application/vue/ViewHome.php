<?php

    /**
     * Vue de la page d'accueil / page de jeu.
     *
     * Affiche la grille de jeu (6 lignes de 5 cases) et le clavier AZERTY.
     * Les boucles ne servent qu'à répéter du HTML. Aucune variable n'est
     * attendue du contrôleur.
    */

    require_once 'header.php';
    start_page('Accueil', 'home');
?>
<main>
    <div class="mode-indicator">
            <span>Daily</span>
    </div>

    <div class="game-container">
        <div class="bloc-grille"> <!--création d'une grille pour le jeu, non fonctionnelle-->
            <div class="grid">
                <?php for ($row = 0; $row < 6; $row++): ?>
                    <div class="row">
                        <?php for ($col = 0; $col < 5; $col++): ?>
                            <div class="tile" data-row="<?= $row ?>" data-col="<?= $col ?>"></div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="right-section">
            <div class="mode-selector">
                <a href="index.php?page=home" class="btn-mode <?= ($_GET['page'] ?? 'home') === 'home' ? 'active' : '' ?>">Daily</a>
                <a href="index.php?page=training" class="btn-mode <?= ($_GET['page'] ?? '') === 'training' ? 'active' : '' ?>">Training</a>
            </div>

            <div class="bloc-clavier"> <!--création d'un clavier pour le jeu, non fonctionnel-->
                <div class="keyboard">
                    <div class="keyboard-row">
                        <?php foreach (['A','Z','E','R','T','Y','U','I','O','P'] as $letter): ?>
                            <button type="button" class="key" data-key="<?= $letter ?>"><?= $letter ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="keyboard-row">
                        <?php foreach (['Q','S','D','F','G','H','J','K','L','M'] as $letter): ?>
                            <button type="button" class="key" data-key="<?= $letter ?>"><?= $letter ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="keyboard-row">
                        <button type="button" class="key key-wide" data-key="Enter">ENTER</button>
                        
                        <?php foreach (['W','X','C','V','B','N'] as $letter): ?>
                            <button type="button" class="key" data-key="<?= $letter ?>"><?= $letter ?></button>
                        <?php endforeach; ?>
                        <button type="button" class="key key-wide" data-key="Backspace">⌫</button>
                    </div>
                </div>
            </div>
            <div id="game-message" class="game-message"></div>
        </div>
    </div>
    <dialog id="game-over-modal" class="game-modal">
        <div class="modal-content">
            <h2 id="modal-title">Fin de partie</h2>
            <p id="modal-message">Message</p>
            <button id="modal-close-btn" class="modal-btn">Rejouer</button>
        </div>
    </dialog>
</main>

<script>
    const secretWord = "<?= $secretWord ?? 'TECHD' ?>";
    const wordId = <?= $wordId ?? 1 ?>;
</script>
<script src="application/javaScript/game.js"></script>

<?php
    end_page();
?>
