<?php
    require_once 'header.php';
    start_page('Accueil');
?>
<main>
    <section class="bloc-grille">
        <div class="grid">
            <?php for ($row = 0; $row < 6; $row++): ?>
                <div class="row">
                    <?php for ($col = 0; $col < 5; $col++): ?>
                        <div class="tile" data-row="<?= $row ?>" data-col="<?= $col ?>"></div>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </div>
    </section>

    <section class="bloc-clavier">
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
                <?php foreach (['W','X','C','V','B','N'] as $letter): ?>
                    <button type="button" class="key" data-key="<?= $letter ?>"><?= $letter ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php
    end_page();
?>
