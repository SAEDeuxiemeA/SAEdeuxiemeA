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
}