<?php

require_once "database.php";

if (isset($_POST["playerId"])) {
    
    if ($_POST["playerId"] == "-1") {
    
        // create player
        mysql_query("INSERT INTO player (id, username, facebook) VALUES (NULL, '" . mysql_real_escape_string($_POST["username"]) . "', '')");
        $playerId = mysql_insert_id();
    } else {
        
        // use player id cached from client
        $playerId = intval($_POST["playerId"]);
    }
}

if (isset($_POST["facebookId"])) {
    
    $playerSearch = mysql_query("SELECT * FROM player WHERE player.facebook = '" . mysql_real_escape_string($_POST["facebookId"]) . "'");
    $playerResult = mysql_fetch_assoc($playerSearch);
    
    if ($playerResult) {
        
        $playerId = $playerResult["id"];
    } else {
        
        mysql_query("INSERT INTO player (id, username, facebook) VALUES (NULL, '" . mysql_real_escape_string($_POST["username"]) . "', '" . mysql_real_escape_string($_POST["facebookId"]) . "')");
        $playerId = mysql_insert_id();
    }
}

// create game
$gameCreate = mysql_query("INSERT INTO game (id, player) VALUES (NULL, " . $playerId . ")");
$gameId = mysql_insert_id();

// return
$return["player_id"] = $playerId;
$return["game_id"] = $gameId;

echo json_encode($return);

?>