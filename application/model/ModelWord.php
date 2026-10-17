<?php
namespace model;

class ModelWord
{
    private int $id;
    private string $word;
    private int $length;
    private string $category;
    private ?string $dailyDate;

    public function __construct(int $id, string $word, int $length, string $category, ?string $dailyDate = null)
    {
        $this->id = $id;
        $this->word = $word;
        $this->length = $length;
        $this->category = $category;
        $this->dailyDate = $dailyDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getDailyDate(): ?string
    {
        return $this->dailyDate;
    }
}
?>