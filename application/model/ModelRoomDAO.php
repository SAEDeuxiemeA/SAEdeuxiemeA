<?php
namespace model;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ModelRoom.php';

class ModelRoomDAO
{
    public function createRoom(string $code, string $username, int $wordId): ?int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'INSERT INTO rooms (code, username, word_id, status)
             VALUES (:code, :username, :word_id, :status)
             RETURNING id'
        );
        $stmt->execute([
            'code'     => $code,
            'username' => $username,
            'word_id'  => $wordId,
            'status'   => 'waiting'
        ]);
        $roomId = $stmt->fetchColumn();
        if ($roomId) {
            //Inscription automatique du créateur dans le salon
            $stmtJoin = $db->prepare(
                'INSERT INTO is_in (username, room_id) VALUES (:username, :room_id)'
            );
            $stmtJoin->execute([
                'username' => $username,
                'room_id'  => (int) $roomId
            ]);
            return (int) $roomId;
        }
        return null;
    }

    public function getRoomByCode(string $code): ?ModelRoom
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, code, username, word_id, status 
             FROM rooms 
             WHERE code = :code'
        );
        $stmt->execute(['code' => $code]);
        $row = $stmt->fetch();
        if ($row) {
            return new ModelRoom(
                $row['code'],
                $row['username'],
                (int) $row['word_id'],
                $row['status'],
                (int) $row['id']
            );
        }
        return null;
    }

    public function getRoomById(int $id): ?ModelRoom
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, code, username, word_id, status 
             FROM rooms 
             WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return new ModelRoom(
                $row['code'],
                $row['username'],
                (int) $row['word_id'],
                $row['status'],
                (int) $row['id']
            );
        }
        return null;
    }

    public function joinRoom(int $roomId, string $username): bool
    {
        $db = Database::getConnection();
        //évite les doublons
        $stmt = $db->prepare(
            'INSERT INTO is_in (username, room_id) 
         VALUES (:username, :room_id)
         ON CONFLICT (username, room_id) DO NOTHING'
        );
        return $stmt->execute([
            'username' => $username,
            'room_id'  => $roomId
        ]);
    }

    public function getPlayers(int $roomId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT username FROM is_in WHERE room_id = :room_id');
        $stmt->execute(['room_id' => $roomId]);
        $rows = $stmt->fetchAll();
        $players = [];
        foreach ($rows as $row) { //pour avoir une liste
            $players[] = $row['username'];
        }
        return $players;
    }

    public function updateStatus(int $roomId, string $status): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE rooms SET status = :status WHERE id = :id');
        return $stmt->execute([
            'status' => $status,
            'id'     => $roomId
        ]);
    }

    public function startGame(int $roomId): bool
    {
        return $this->updateStatus($roomId, 'playing');
    }

    public function deleteRoom(int $id): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM rooms WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
?>