<?php

require_once "database.php";

/*
$query = mysql_query("
    SELECT
        player.username,
        sausage.player AS player_id,
        sausage.game AS game_id,
        SUM(sausage.score) AS total_score
    FROM sausage, player
    WHERE sausage.player = player.id
    GROUP BY game_id
    ORDER BY total_score
    DESC
");
*/

$query = mysql_query("
    SELECT DISTINCT * FROM
    (
        SELECT
            player.username,
            sausage.player AS player_id,
            sausage.game AS game_id,
            SUM(sausage.score) AS total_score
        FROM sausage, player
        WHERE sausage.player = player.id AND sausage.time = CURDATE()
        GROUP BY game_id
        ORDER BY total_score
        DESC
    ) AS r
    GROUP BY player_id
    ORDER BY total_score
    DESC LIMIT 10
");
$result = array();
$position = 1;
    
while ($r = mysql_fetch_assoc($query)) {
    
    if ($r["game_id"] == $_GET["gameId"]) {
        
        $return["position"] = $position;
        $return["total_score"] = $r["total_score"];
        $return["username"] = $r["username"];
        break;
    }
    
    $position++;
}

echo json_encode($return);

?>