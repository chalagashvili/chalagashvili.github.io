<?php

require_once "database.php";

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
$result = array();
$position = 1;

while ($r = mysql_fetch_assoc($query)) {
    
    if ($r["player_id"] == $_GET["playerId"]) {
        
        $return["position"] = $position;
        $return["total_score"] = $r["total_score"];
        $return["username"] = $r["username"];
        break;
    }
    
    $position++;
}

echo json_encode($return);

?>