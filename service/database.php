<?php

include "../config.php";

$mysql = mysql_connect($db_url, $username, $password);

mysql_select_db($db_name);
mysql_query("SET NAMES utf8");

?>