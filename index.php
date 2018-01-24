<?php

include 'php/Mobile_Detect.php';

$detect = new Mobile_Detect();

if ($detect->isMobile()) {
    include "mobile.php";
} else {
    include "site.php";
}

?>