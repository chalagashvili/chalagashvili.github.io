<?php

require_once "database.php";

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
    ORDER BY total_score DESC, player_id ASC
    LIMIT 10
");

$result = array();
    
while ($r = mysql_fetch_assoc($query)) {
    $result[] = $r;
}

$return["highscore"] = $result;

echo json_encode($return);

?>