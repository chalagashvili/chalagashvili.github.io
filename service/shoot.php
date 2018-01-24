<?php

require_once "database.php";

// vars
$score = 0;
$position = -1;

// get targets
$targetQuery = mysql_query("
        SELECT *
        FROM target
        ORDER BY id
        ASC
    ");

while ($targetItem = mysql_fetch_assoc($targetQuery)) {
    
    $dx = ($targetItem["x"] * 640) - (640 * $_POST["offset"]);
    $dy = ($targetItem["y"] * 480) - (480 * (1 - $_POST["power"]));
    $dist = sqrt($dx * $dx + $dy * $dy);
	
    switch ($targetItem["difficulty"]) {
        
        case "1": $hitArea = 100; $pointRange = 25; break;
        case "2": $hitArea = 50; $pointRange = 50; break;
        case "3": $hitArea = 25; $pointRange = 100; break;
    }
    
    if ($dist < $hitArea) {
        
        $score = abs($pointRange - floor(($dist / $hitArea) * $pointRange));
        
        // update target position
        mysql_query("
            UPDATE target
            SET y = RAND(), difficulty = (1 + FLOOR(RAND() * 3))
            WHERE id = " . $targetItem["id"]
        );
    }
}

/*
// calculate score
$dx = 320 - (640 * $_POST["offset"]);
$dy = 240 - (480 * $_POST["power"]);
$dist = sqrt($dx * $dx + $dy * $dy);
$score = abs(100 - floor(($dist / 320) * 100));
$position = -1;
*/

// submit sausage
$sausageResult = mysql_query("
    INSERT INTO sausage (
        id,
        player,
        game,
        power,
        offset,
        score,
        time
    )
    VALUES (
        NULL,
        " . mysql_real_escape_string($_POST["playerId"]) . ",
        " . mysql_real_escape_string($_POST["gameId"]) . ",
        " . mysql_real_escape_string($_POST["power"]) . ",
        " . mysql_real_escape_string($_POST["offset"]) . ",
        " . $score . ",
        CURDATE())
");

// check shots fired
$shotsFiredResult = mysql_query("
    SELECT *
    FROM sausage
    WHERE sausage.game = " . mysql_real_escape_string($_POST["gameId"])
);
$shotsFired = array();

while ($r = mysql_fetch_assoc($shotsFiredResult)) {
    $shotsFired[] = $r;
}

if (count($shotsFired) == 3) { // check if all shots are fired
    
    // add game timestamp
    mysql_query("
        UPDATE game
        SET time = now()
        WHERE id = " . $_POST["gameId"]
    );
}

// return
$return["score"] = $score;
$return["shots_fired"] = count($shotsFired);
$return["game_over"] = (count($shotsFired) == 3) ? true : false;

echo json_encode($return);

?>