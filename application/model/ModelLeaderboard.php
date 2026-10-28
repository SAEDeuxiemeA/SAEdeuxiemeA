<?php
namespace model;

class ModelLeaderboard
{
    private int $rank;

    private string $username;

    private ?int $attemps;

    private ?float $seconds;

    private ?int $points;

    private ?int $wins;

    private ?int $games;


    public function __construct(
        int $rank,
        string $username,
        ?int $attemps = null,
        ?float $seconds = null,
        ?int $points = null,
        ?int $wins = null,
        ?int $games = null)
    {
        $this->rank = $rank;
        $this->username = $username;
        $this->attemps = $attemps;
        $this->seconds = $seconds;
        $this->points = $points;
        $this->wins = $wins;
        $this->games = $games;
    }

    public function getRank(): int
    {
        return $this->rank; 
    }  
    
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getAttemps() : ?int
    {
        return $this->attemps;
    }

    public function getSeconds() : ?float
    {
        return $this->seconds;
    }

    public function getPoints() : ?int
    {
        return $this->points;
    }

    public function getWins() : ?int
    {
        return $this->wins;
    }

    public function getGames() : ?int
    {
        return $this->games;
    }
}