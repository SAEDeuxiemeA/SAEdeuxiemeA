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

    public function getGameById(int $gameId): ?ModelGame
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, username, word_id, room_id, attempts, time_seconds, is_won, played_at 
             FROM games 
             WHERE id = :id'
        );
        $stmt->execute(['id' => $gameId]);
        $row = $stmt->fetch();
        if ($row) {
            $guesses = $this->getGuessesByGameId((int) $row['id']);
            return new ModelGame(
                (int) $row['id'],
                $row['username'],
                (int) $row['word_id'],
                $row['room_id'] !== null ? (int) $row['room_id'] : null,
                (int) $row['attempts'],
                $row['time_seconds'] !== null ? (int) $row['time_seconds'] : null,
                (bool) $row['is_won'],
                $row['played_at'],
                $guesses
            );
        }
        return null;
    }

    public function getDailyGameByUser(string $username, int $wordId): ?ModelGame
    {
        $db = Database::getConnection();
        //room_id IS NULL pour la partie Daily
        $stmt = $db->prepare(
            'SELECT id, username, word_id, room_id, attempts, time_seconds, is_won, played_at 
             FROM games 
             WHERE username = :username AND word_id = :word_id AND room_id IS NULL'
        );
        $stmt->execute([
            'username' => $username,
            'word_id'  => $wordId
        ]);
        $row = $stmt->fetch();
        if ($row) {
            $guesses = $this->getGuessesByGameId((int) $row['id']);
            return new ModelGame(
                (int) $row['id'],
                $row['username'],
                (int) $row['word_id'],
                null,
                (int) $row['attempts'],
                $row['time_seconds'] !== null ? (int) $row['time_seconds'] : null,
                (bool) $row['is_won'],
                $row['played_at'],
                $guesses
            );
        }
        return null;
    }

    public function getRoomGameByUser(string $username, int $roomId): ?ModelGame
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, username, word_id, room_id, attempts, time_seconds, is_won, played_at 
             FROM games 
             WHERE username = :username AND room_id = :room_id'
        );
        $stmt->execute([
            'username' => $username,
            'room_id'  => $roomId
        ]);
        $row = $stmt->fetch();
        if ($row) {
            $guesses = $this->getGuessesByGameId((int) $row['id']);
            return new ModelGame(
                (int) $row['id'],
                $row['username'],
                (int) $row['word_id'],
                (int) $row['room_id'],
                (int) $row['attempts'],
                $row['time_seconds'] !== null ? (int) $row['time_seconds'] : null,
                (bool) $row['is_won'],
                $row['played_at'],
                $guesses
            );
        }
        return null;
    }
}
?>