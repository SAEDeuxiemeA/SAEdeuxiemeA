<?php
namespace model;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ModelWord.php';

class ModelWordDAO
{
    public function getDailyWord(): ?ModelWord
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id, word, length, category, daily_date FROM words WHERE daily_date = CURRENT_DATE');
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            return new ModelWord(
                (int) $row['id'],
                $row['word'],
                (int) $row['length'],
                $row['category'],
                $row['daily_date']
            );
        }
        return null;
    }

    public function getWordById(int $id): ?ModelWord
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id, word, length, category, daily_date FROM words WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return new ModelWord(
                (int) $row['id'],
                $row['word'],
                (int) $row['length'],
                $row['category'],
                $row['daily_date']
            );
        }
        return null;
    }

    public function getRandomWord(): ?ModelWord
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id, word, length, category, daily_date FROM words ORDER BY RANDOM() LIMIT 1');
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            return new ModelWord(
                (int) $row['id'],
                $row['word'],
                (int) $row['length'],
                $row['category'],
                $row['daily_date']
            );
        }
        return null;
    }
}
?>