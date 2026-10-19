<?php
require_once 'header.php';
start_page('LeaderboardDaily', 'leaderboard');
?>

<main class="classement-container">
    <nav class="tabs-nav">
        <a href="index.php?page=classement&amp;filter=daily" class="tab-btn active">Daily</a>
        <a href="index.php?page=classement&amp;filter=global" class="tab-btn">Global</a>
    </nav>

    <section class="podium-section">
        <div class="podium-step step-2">
            <span class="rank-number">2</span>
            <div>
                <strong>Joueur 2</strong>
            </div>
        </div>

        <div class="podium-step step-1">
            <span class="rank-number">1</span>
            <div>
                <strong>Joueur 1</strong>
            </div>
        </div>

        <div class="podium-step step-3">
            <span class="rank-number">3</span>
            <div>
                <strong>Joueur 3</strong>
            </div>
        </div>
    </section>

    <section class="ranking-list-section">
        <p class="ranking-title">Suite du classement avec daily de chaque personne</p>

        <ul class="ranking-list">
                <li class="ranking-item">
                <span class="rank-index">#4</span>
                <span class="username">Joueur 4</span>
            </li>
            <li class="ranking-item">
                <span class="rank-index">#5</span>
                <span class="username">Joueur 5</span>
            </li>
            <li class="ranking-item">
                <span class="rank-index">#6</span>
                <span class="username">Joueur 6</span>
            </li>
            <li class="ranking-item">
                <span class="rank-index">#7</span>
                <span class="username">Joueur 7</span>
            </li>
        </ul>
    </section>
</main>

<?php
end_page();
?>