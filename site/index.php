<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Entity/Game.php';
require_once __DIR__ . '/src/Entity/Player.php';
require_once __DIR__ . '/src/Repository/GameRepository.php';

use App\Entity\Game;
use App\Entity\Player;

// $message = "";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>APOCALYPT IA</title>
</head>

<body>
    <nav>
        <form action="action.php" method="POST">
            <button type="submit" name="action" value="restart">Restart Game</button>
            <button type="submit" name="action" value="new">New Game</button>
        </form>
    </nav>

    <main>
        <h1>APOCALYPT IA</h1>
        <h2>Day <?= htmlspecialchars($game->getCurrentDay()) ?>/30</h2>
        <p><?= htmlspecialchars($message) ?></p>
        <section>
            <h3>Character's stats</h3>
            <p>✧ health : <?= htmlspecialchars($game->getHealth()) ?> %</p>
            <p>✧ energy : <?= htmlspecialchars($game->getEnergy()) ?> %</p>
            <p>✧ food : <?= htmlspecialchars($game->getFood()) ?> %</p>
            <p>✧ materials : <?= htmlspecialchars($game->getMaterials()) ?></p>
            <form action="action.php" method="POST">
                <!-- input csrf token -->
                <button type="submit" name="action" value="food">Look for Food</button>
                <button type="submit" name="action" value="materials">Look for materials</button>
                <button type="submit" name="action" value="rest">Rest</button>
                <button type="submit" name="action" value="repare">Repare hideout</button>
                <button type="submit" name="action" value="next_day">Jour suivant</button>
            </form>
        </section>
    </main>


</body>

</html>