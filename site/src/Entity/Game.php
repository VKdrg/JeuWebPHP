<?php
namespace App\Entity;

class Game
{
    private int $energy;
    private int $health;
    private int $food;
    private int $materials;

    public function __construct(int $energy, int $health, int $food, int $materials)
    {
        $this->energy = $energy;
        $this->health = $health;
        $this->food = $food;
        $this->materials = $materials;
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