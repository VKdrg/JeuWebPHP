<?php
namespace App\Entity;

class Game
{
    private int $id_game;
    private int $current_day;
    private int $energy;
    private int $health;
    private int $food;
    private int $materials;

    public function __construct(int $id_game, int $current_day, int $energy, int $health, int $food, int $materials)
    {
        $this->id_game = $id_game;
        $this->current_day = $current_day;
        $this->energy = $energy;
        $this->health = $health;
        $this->food = $food;
        $this->materials = $materials;
    }

    public function getIdGame(): int
    {
        return $this->id_game;
    }

    public function getCurrentDay(): int
    {
        return $this->current_day;
    }

    public function getEnergy(): int
    {
        return $this->energy;
    }

    public function getHealth(): int
    {
        return $this->health;
    }
    
    public function getFood(): int
    {
        return $this->food;
    }

    public function getMaterials(): int
    {
        return $this->materials;
    }

}
?>