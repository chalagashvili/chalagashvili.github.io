<?php

require_once "database.php";

// sausages

if (isset($_POST["id"])) { // get all sausages from this id
    
    $sausageQuery = mysql_query("
        SELECT
            sausage.id AS id,
            sausage.power AS power,
            sausage.offset AS offset,
            sausage.score AS score,
            player.username AS username
        FROM sausage, player
        WHERE sausage.id > " . mysql_real_escape_string($_POST["id"]) . " AND sausage.player = player.id
        ORDER BY id DESC
    ");
    
} else { // get latest sausage
    
    $sausageQuery = mysql_query("
        SELECT
            sausage.id AS id,
            sausage.power AS power,
            sausage.offset AS offset,
            sausage.score AS score,
            player.username AS username
        FROM sausage, player
        ORDER BY id DESC LIMIT 1
    ");    
}

$sausages = array();

while ($s = mysql_fetch_assoc($sausageQuery)) {
    $sausages[] = $s;
}

// targets

$targetQuery = mysql_query("
        SELECT *
        FROM target
        ORDER BY id
        ASC
    ");

$targets = array();

while ($t = mysql_fetch_assoc($targetQuery)) {
    $targets[] = $t;
}

// return data

$return["sausages"] = $sausages;
$return["targets"] = $targets;

echo json_encode($return);

?>