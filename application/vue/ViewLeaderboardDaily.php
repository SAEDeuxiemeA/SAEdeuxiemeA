<?php
/**
 * Vue du classement quotidien.
 *
 * Variables fournies par le contrôleur :
 *
 * @var array[] $rows Lignes du classement, déjà triées par rang, chaque ligne est un tableau associatif avec les clés :
 *                    `['rank' => int, 'username' => string, 'attempts' => int, 'seconds' => float]`.
 *                    Les 3 premières lignes vont sur le podium, les suivantes dans la liste.
 */


require_once 'header.php';
start_page('LeaderboardDaily', 'leaderboard');

$rows = $rows ?? [];
?>

<main class="classement-container">

    <?php /* COMPOSANT : onglets (aucune donnée, seulement deux liens) */ ?>
    <nav class="tabs-nav">
        <a href="index.php?page=classement&amp;filter=daily" class="tab-btn active">Daily</a>
        <a href="index.php?page=classement&amp;filter=global" class="tab-btn">Global</a>
    </nav>

    <?php /* COMPOSANT : podium (données : les 3 premières lignes de $rows, ordre d'affichage 2, 1, 3) */ ?>
    <section class="podium-section">
        <div class="podium-step step-2">
            <span class="rank-number">2</span>
            <div>
                <strong><?= htmlspecialchars($rows[1]['username'] ?? '-') ?></strong>
            </div>
        </div>

        <div class="podium-step step-1">
            <span class="rank-number">1</span>
            <div>
                <strong><?= htmlspecialchars($rows[0]['username'] ?? '-') ?></strong>
            </div>
        </div>

        <div class="podium-step step-3">
            <span class="rank-number">3</span>
            <div>
                <strong><?= htmlspecialchars($rows[2]['username'] ?? '-') ?></strong>
            </div>
        </div>
    </section>

    <?php /* COMPOSANT : liste du classement (données : les lignes de $rows à partir de la 4e) */ ?>
    <section class="ranking-list-section">
        <p class="ranking-title">Suite du classement avec daily de chaque personne</p>

        <ul class="ranking-list">
            <?php foreach (array_slice($rows, 3) as $row): ?>
                <?php /* COMPOSANT : une ligne de la liste */ ?>
                <li class="ranking-item">
                    <span class="rank-index">#<?= (int) $row['rank'] ?></span>
                    <span class="username"><?= htmlspecialchars($row['username']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>

<?php
end_page();
?>