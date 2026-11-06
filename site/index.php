<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Entity/Game.php';
require_once __DIR__ . '/src/Entity/Player.php';
// require_once __DIR__ . '/src/Repository/action.php';

use App\Entity\Game;
use App\Entity\Player;

// $health = 100;
// $energy = 100;
// $food = 60;
// $materials = 0;

$game = new Game(1, 1, 100, 100, 60, 0);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APOCALYPT IA</title>
</head>
<body>
    <h1>APOCALYPT IA</h1>
    <h2>Day <?= htmlspecialchars($game->getCurrentDay()) ?>/30</h2>
    <p><?= htmlspecialchars($message) ?></p>
    <section>
        <h3>Character's stats</h3>
        <ul>
            <li>health : <?= htmlspecialchars($game->getHealth()) ?> %</li>
            <li>energy : <?= htmlspecialchars($game->getEnergy()) ?> %</li>
            <li>food : <?= htmlspecialchars($game->getFood()) ?> %</li>
            <li>materials : <?= htmlspecialchars($game->getMaterials()) ?></li>
        </ul>
    </section>
    <form action="src/Repository/action.php" method="POST">
        <!-- input csrf token -->
        <button type="submit" name="action" value="food">Look for Food</button>
        <button type="submit" name="action" value="materials">Look for materials</button>
        <button type="submit" name="action" value="rest">Rest</button>
        <button type="submit" name="action" value="repare">Repare hideout</button>
    </form>


</body>
</html>