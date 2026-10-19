<?php
namespace model;

class ModelGame
{
    private int $id;
    private string $username;
    private int $wordId;
    private ?int $roomId; //NULL si partie Daily solo, ou numéro du salon si multijoueur
    private int $attempts;
    private ?int $timeSeconds;  //NULL tant que la partie n'est pas terminée
    private bool $isWon;
    private ?string $playedAt;
    public function __construct(
        int $id,
        string $username,
        int $wordId,
        ?int $roomId,
        int $attempts,
        ?int $timeSeconds,
        bool $isWon,
        ?string $playedAt = null,
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->wordId = $wordId;
        $this->roomId = $roomId;
        $this->attempts = $attempts;
        $this->timeSeconds = $timeSeconds;
        $this->isWon = $isWon;
        $this->playedAt = $playedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getWordId(): int
    {
        return $this->wordId;
    }

    public function getRoomId(): ?int
    {
        return $this->roomId;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getTimeSeconds(): ?int
    {
        return $this->timeSeconds;
    }

    public function isWon(): bool
    {
        return $this->isWon;
    }

    public function getPlayedAt(): ?string
    {
        return $this->playedAt;
    }
}
?>