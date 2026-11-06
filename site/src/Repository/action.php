<?php
// require
    use App\Entity\Game;
    use App\Entity\Player;

// define ids
    $id_game = 0;
    // $game = new Game;

    // $health = 100;
    // $energy = 100;
    // $food = 60;
    // $materials = 0;

    // $sql = "SELECT food FROM Game WHERE id_game = :id_game";

// actions 
    $action = $_POST['action'];

    // stats

    // actions
        if ($action === 'food') {
            # set health +20 && food +20 && energy -20
            $sql = "UPDATE Game
                    SET health = LEAST(health += 20, 100)  -- health +20, max 100
                    SET food = LEAST(food += 20, 100)      -- food +20, max 100
                    SET energy -= 20                       -- energy -20
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);
        }

        if ($action === 'materials') {
            # set food -10 && energy -20 && materials +5
            $sql = "UPDATE Game
                    SET food -= 10
                    SET energy -= 20
                    SET materials += 5
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);
        }

        if ($action === 'rest') {
            # set food -20 && health +10 && energy +20
            $sql = "UPDATE Game
                    SET food -= 20
                    SET health = LEAST(health +=20, 100)
                    SET energy = LEAST(energy +20, 100)
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);
        }

        if ($action == 'repare') {
            # set energy -30 && materials -5 && food -20
            $sql = "UPDATE Game
                    SET energy -= 30
                    SET materials -=5
                    SET food -= 20
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);

            if ($game->getMaterials() < 5) {
                $message = 'Materials too low, you can\'t repare the hideout !';
            }
        }

    // stats too low
        if ($game->getFood() <= 0) {
            # set energy -20 && health -10
            $sql = "UPDATE Game
                    SET energy -= 20
                    SET health -= 10
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);
            sleep(10);
        }
        if ($game->getEnergy() === 0) {
            # set health -20
            $sql = "UPDATE Game
                    SET health -= 20
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);
            sleep(10);
        }
        if ($game->getHealth() === 0) {
            # set energy -20
            $sql = "UPDATE Game
                    SET energy -= 20
                    WHERE id_game = :id_game";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_game' => $id_game
            ]);
            sleep(10);
        }
    
    // progress
        $currentDay = 0;

        if ($action === 'next_day') {
            $currentDay ++;

            if ($currentDay === 30 && ($game->getHealth() >0 ||$game->getEnergy() >0)) {
                header('Location : /endgame.php');
            }
        }
?>