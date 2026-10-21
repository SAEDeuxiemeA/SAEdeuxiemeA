<?php
    require_once 'header.php';
    start_page('Profile', 'profile');
?>
<main class="profile">
    <section class="profile-avatar">
       <p>Avatar</p> 
    </section>
    <h1 class="profile-name"><?= htmlspecialchars($account->getLogin(), ENT_QUOTES, 'UTF-8')?> </label></h1>

    <dl class="profile-stats">
        <div class="stat">
            <dt>Best Streak</dt>
            <dd>-waiting value-</dd>
        </div>
        <div class="stat">
            <dt>Win Percentage</dt>
            <dd>-waiting value-</dd>
        </div>
        <div class="stat">
            <dt>Number of duels won</dt>
            <dd>-waiting value</dd>
        </div>
        <div class="stat">
            <dt>Rank</dt>
            <dd>-waiting value</dd>
        </div>
    </dl>

    <section class="profile-badges" aria-labelledby="badges-title">
        <h2 id="badges-title" class="sr-only">Badges</h2>
        <ul>
            <li>BADGE</li>
            <li>BADGE</li>
            <li>BADGE</li>
            <li>BADGE</li>
            <li>BADGE</li>
            <li>BADGE</li>
        </ul>
    </section>

    <a class="profile-logout" href="index.php?page=login&amp;action=logout">Log Out</a>
</main>
<?php
    end_page();
?>