<?php
namespace model;

use PDO;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ModelLeaderboard.php';
require_once __DIR__ . '/ModelGameDAO.php';

class ModelLeaderboardDAO
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getGlobalLeaderboard(): array
{
    $query = "
        SELECT
            g.username,
            SUM((w.length + 1) - g.attempts) AS total_points
        FROM games g
        INNER JOIN words w ON w.id = g.word_id
        WHERE g.is_won = TRUE
        GROUP BY g.username
        ORDER BY total_points DESC, g.username ASC
        LIMIT 10
    ";

    $stmt = $this->db->query($query);
    $rows = [];
    $rank = 1;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = new ModelLeaderboard(
            $rank++,
            $row['username'],
            null,
            null,
            (int) $row['total_points'],
            null,
            null
        );
    }

    return $rows;
}

    public function getDailyLeaderboard(): array
    {
        $query = "
            WITH best_games AS (
                SELECT
                    g.username,
                    g.attempts,
                    g.time_seconds,
                    ROW_NUMBER() OVER (PARTITION BY g.username ORDER BY g.attempts ASC, g.time_seconds ASC) AS rn
                FROM games g
            INNER JOIN words w ON w.id = g.word_id
            WHERE g.room_id IS NULL
            AND w.daily_date = CURDATE()
            AND g.time_seconds IS NOT NULL
            AND g.is_won = TRUE)

            SELECT username, attempts, time_seconds
            FROM best_games
            WHERE rn = 1
            ORDER BY attempts ASC, time_seconds ASC
            LIMIT 10;";

        $stmt = $this->db->query($query);
        $rows = [];
        $rank = 1;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = new ModelLeaderboard(
                $rank++,
                $row['username'],
                (int) $row['attempts'],
                $row['time_seconds'] !== null ? (float) $row['time_seconds'] : null,
                null,
                null,
                null
            );
        }

        return $rows;
    }
}