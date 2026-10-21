<?php
/**
 * Vue du classement global (cumul des parties quotidiennes de chaque joueur).
 *
 * Variables fournies par le contrôleur :
 *
 * @var model\ModelLeaderboard[] $rows Lignes du classement global déjà triées.
 *
 */

require_once 'header.php';
start_page('LeaderboardGlobal', 'leaderboard');

$rows = $rows ?? [];
?>

<main class="classement-container">

    <?php /* COMPOSANT : onglets (aucune donnée, seulement deux liens ; l'onglet Global est actif) */ ?>
    <nav class="tabs-nav">
        <a href="index.php?page=classement&amp;filter=daily" class="tab-btn">Daily</a>
        <a href="index.php?page=classement&amp;filter=global" class="tab-btn active">Global</a>
    </nav>

    <?php /* COMPOSANT : podium (données : les 3 premières lignes de $rows, ordre d'affichage 2, 1, 3) */ ?>
    <section class="podium-section">
        <div class="podium-step step-2">
            <span class="rank-number">2</span>
            <div>
                <strong><?= htmlspecialchars($rows[1]->getUsername() ?? '-') ?></strong>
            </div>
        </div>

        <div class="podium-step step-1">
            <span class="rank-number">1</span>
            <div>
                <strong><?= htmlspecialchars($rows[0]->getUsername() ?? '-') ?></strong>
            </div>
        </div>

        <div class="podium-step step-3">
            <span class="rank-number">3</span>
            <div>
                <strong><?= htmlspecialchars($rows[2]->getUsername() ?? '-') ?></strong>
            </div>
        </div>
    </section>

    <?php /* COMPOSANT : liste du classement (données : les lignes de $rows à partir de la 4e) */ ?>
    <section class="ranking-list-section">
        <p class="ranking-title">Suite du classement avec l'accumulation des daily de chaque personne</p>

        <ul class="ranking-list">
            <?php foreach (array_slice($rows, 3) as $row): ?>
                <?php /* COMPOSANT : une ligne de la liste */ ?>
                <li class="ranking-item">
                    <span class="rank-index">#<?= (int) $row->getRank() ?></span>
                    <span class="username"><?= htmlspecialchars($row->getUsername()) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>

<?php
end_page();
?>