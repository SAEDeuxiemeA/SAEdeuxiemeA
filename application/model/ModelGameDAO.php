<?php
namespace model;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ModelGame.php';

class ModelGameDAO
{
    public function createGame(string $username, int $wordId, ?int $roomId = null): ?int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'INSERT INTO games (username, word_id, room_id, attempts, is_won) 
             VALUES (:username, :word_id, :room_id, 0, FALSE) 
             RETURNING id'
        );
        $stmt->execute([
            'username' => $username,
            'word_id'  => $wordId,
            'room_id'  => $roomId
        ]);
        $row = $stmt->fetch();
        return $row ? (int) $row['id'] : null;
    }

    public function finishGame(int $gameId, int $attempts, int $timeSeconds, bool $isWon): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'UPDATE games 
             SET attempts = :attempts, time_seconds = :time_seconds, is_won = :is_won 
             WHERE id = :id'
        );
        return $stmt->execute([
            'attempts'     => $attempts,
            'time_seconds' => $timeSeconds,
            'is_won'       => $isWon ? 'true' : 'false', //conversion en 'true'/'false' pour éviter les erreurs de typage sur PostgreSQL
            'id'           => $gameId
        ]);
    }

    public function addGuess(int $gameId, int $attemptNumber, string $guessWord): bool
    {
        $db = Database::getConnection();
        $cleanGuess = strtoupper(trim($guessWord)); //nettoie le mot tapé
        $stmt = $db->prepare(
            'INSERT INTO guesses (game_id, attempt_number, guess_word) 
             VALUES (:game_id, :attempt_number, :guess_word)'
        );

        $inserted = $stmt->execute([
            'game_id'        => $gameId,
            'attempt_number' => $attemptNumber,
            'guess_word'     => $cleanGuess
        ]);
        //met à jour le compteur d'essais dans la table games
        if ($inserted) {
            $updateStmt = $db->prepare('UPDATE games SET attempts = :attempts WHERE id = :id');
            $updateStmt->execute([
                'attempts' => $attemptNumber,
                'id'       => $gameId
            ]);
        }
        return $inserted;
    }

    public function getGuessesByGameId(int $gameId): array
    {
        $db = Database::getConnection();
        //Tri croissant pour récupérer les lignes de la grille dans l'ordre
        $stmt = $db->prepare(
            'SELECT attempt_number, guess_word 
             FROM guesses 
             WHERE game_id = :game_id 
             ORDER BY attempt_number ASC'
        );
        $stmt->execute(['game_id' => $gameId]);
        return $stmt->fetchAll();
    }
}
?>