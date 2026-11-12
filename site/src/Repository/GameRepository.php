<?php
// requires
    require_once __DIR__ . '/../../config/database.php';
    require_once __DIR__ . '/../Entity/Game.php';
    // require_once __DIR__ . '/../../index.php';
    use App\Entity\Game;


// logic
$gameId = 1;

$stmt = $pdo->prepare(
    'SELECT id_game, current_day, energy, health, food, materials
    FROM Game
    WHERE id_game = :id'
);
$stmt->execute(['id' => $gameId]);
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
?>