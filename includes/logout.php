<?php
include "../core/init.php";
$getFromU->logout();
if($getFromU->loggetIn() === false) {
    header("Location: index.php");
    exit;
}