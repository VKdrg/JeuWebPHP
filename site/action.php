<?php
// require
    require_once __DIR__ . '/config/database.php';
    require_once __DIR__ . '/src/Entity/Game.php';
    use App\Entity\Game;

// define ids
    $game = new Game(1,1,100,100,60,0);

// function newGame = requête sql et attribution ==> aka "jour suivant" = la même chose mais dans les 2 sens du sql

    $sql = "SELECT id_game, current_day, energy, health, food, materials FROM Game WHERE id_game = :id_game";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id_game' => $game->getIdGame()
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        http_response_code(404);
        exit('Game not found');
    }

    $game = new Game(
        (int) $row['id_game'],
        (int) $row['current_day'],
        (int) $row['energy'],
        (int) $row['health'],
        (int) $row['food'],
        (int) $row['materials']
    );

// actions error
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) 
    {
        http_response_code(400);
        exit('Invalid form submission');
    }
    $action = $_POST['action'];

// actions
    if ($action === 'food') {
        # set health +20 && food +20 && energy -20
        $sql = "UPDATE Game
                SET health = LEAST(health + 20, 100), food = LEAST(food + 20, 100), energy = energy - 20
                WHERE id_game = :id_game";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);
    }

    if ($action === 'materials') {
        # set food -10 && energy -20 && materials +5
        $sql = "UPDATE Game
                SET food = food - 10, energy = energy - 20, materials = materials + 5
                WHERE id_game = :id_game";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);
    }

    if ($action === 'rest') {
        # set food -20 && health +10 && energy +20
        $sql = "UPDATE Game
                SET food = food - 20, health = LEAST(health +20, 100), energy = LEAST(energy +20, 100)
                WHERE id_game = :id_game";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);
    }

    if ($action === 'repare' && $game->getMaterials() > 0) {
        # set energy -30 && materials -5 && food -20
        $sql = "UPDATE Game
                SET energy = energy - 30, materials = materials -5, food = food - 20
                WHERE id_game = :id_game";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);

        if ($game->getMaterials() < 5) {
            $message = 'Materials too low, you can\'t repare the hideout !';
        }
    }

    if ($action && $game->getFood() <= 0) {
        # set health -30 && energy -20
        $sql = "UPDATE Game
                SET health = health - 30, energy = energy - 20, food = 0
                WHERE id_game = :id_game";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);
    }
    elseif ($action && $game->getEnergy() <= 0) {
        # set health -30
        $sql = "UPDATE Game
                SET health = health - 30, energy = 0
                WHERE id_game = :id_game";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);
    }

// // stats too low
//     // fetch updated DB values
//     $stmt = $pdo->prepare(
//         'SELECT id_game, current_day, energy, health, food, materials
//         FROM Game WHERE id_game = :id_game'
//     );
//     $stmt->execute(['id_game' => $game->getIdGame()]);
//     $row = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($row === false) {
//         http_response_code(404);
//         exit('Game not found');
//     }

//     $game = new Game(
//         (int) $row['id_game'],
//         (int) $row['current_day'],
//         (int) $row['energy'],
//         (int) $row['health'],
//         (int) $row['food'],
//         (int) $row['materials']
//     );

//     // apply consequences
//     if ($game->getFood() <= 0 && $game->getEnergy() <30) {
//         # set energy -20 && health -10
//         $sql = "UPDATE Game
//                 SET energy = energy - 20, health = health - 10
//                 WHERE id_game = :id_game";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([
//             'id_game' => $game->getIdGame()
//         ]);
//         sleep(10);
//     }
//     if ($game->getEnergy() <= 0) {
//         # set health -20
//         $sql = "UPDATE Game
//                 SET health = health - 20
//                 WHERE id_game = :id_game";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([
//             'id_game' => $game->getIdGame()
//         ]);
//         // sleep(10);
//     }
//     if ($game->getHealth() <= 0) {
//         # set energy -20
//         $sql = "UPDATE Game
//                 SET energy = energy - 20
//                 WHERE id_game = :id_game";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([
//             'id_game' => $game->getIdGame()
//         ]);
//         // sleep(10);
//     }

// other actions
    if($action === 'restart') {
        $sql = "UPDATE Game
                SET current_day = 1, health = 100, energy = 100, food = 60, materials = 0
                WHERE id_game = :id_game";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([
            'id_game' => $game->getIdGame()
        ]);
    }
    
    // progress
        $currentDay = $game->getCurrentDay();

        if ($action === 'next_day') {
            $sql = "UPDATE Game
                    SET current_day = current_day +1, health = LEAST(health +20, 100), energy = LEAST(energy +20, 100), food = food -40
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $game->getIdGame()
            ]);
        }

        if ($currentDay >= 30 && ($game->getHealth() > 0 || $game->getEnergy() > 0)) {
            header('Location: /imts/imts/00_Exercices/04_JeuWebPHP/site/endgame.php');
        }
        elseif ($currentDay < 30 && ($game->getHealth() <= 0 || $game->getEnergy() <= 0)) {
            header('Location: /imts/imts/00_Exercices/04_JeuWebPHP/site/gameover.php');
        }
        else {
            header('Location: /imts/imts/00_Exercices/04_JeuWebPHP/site/index.php');
        }
        
?>