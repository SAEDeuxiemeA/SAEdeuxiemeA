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

    public function addWord(string $word, string $category, ?string $dailyDate = null): bool
    {
        $db = Database::getConnection();
        $cleanWord = strtoupper(trim($word)); //on nettoie le texte
        $length = mb_strlen($cleanWord); //calcul du nombre de lettres
        $stmt = $db->prepare(
            'INSERT INTO words (word, length, category, daily_date)
             VALUES (:word, :length, :category, :daily_date)'
        );
        return $stmt->execute([
            'word'       => $cleanWord,
            'length'     => $length,
            'category'   => $category,
            'daily_date' => $dailyDate
        ]);
    }

    public function findWord(string $word): bool
    {
        $db = Database::getConnection();
        $cleanWord = strtoupper(trim($word));
        $stmt = $db->prepare('SELECT word FROM words WHERE word = :word');
        $stmt->execute(['word' => $cleanWord]);
        return $stmt->fetch() !== false;
    }

    public function getAllWords(): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id, word, length, category, daily_date FROM words ORDER BY id DESC');
        $stmt->execute();
        $rows = $stmt->fetchAll(); //recuperation de toutes les lignes
        $words = [];
        foreach ($rows as $row) { //parcourt chaque ligne
            $words[] = new ModelWord(
                (int) $row['id'],
                $row['word'],
                (int) $row['length'],
                $row['category'],
                $row['daily_date']
            );
        }
        return $words;
    }

    public function deleteWord(int $id): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM words WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
?>