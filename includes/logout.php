<?php
include "../core/init.php";
$getFromU->logout();
if ($getFromU->loggetIn() === false) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}
