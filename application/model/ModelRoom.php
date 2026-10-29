<?php
namespace model;

class ModelRoom
{
    private ?int $id;
    private string $code;
    private string $username;
    private int $word_id;
    private string $status;

    public function __construct(string $code, string $username, int $word_id, string $status = 'waiting', ?int $id = null)
    {
        $this->id = $id;
        $this->code = $code;
        $this->username = $username;
        $this->word_id = $word_id;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getWordId(): int
    {
        return $this->word_id;
    }

    public function getStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
?>