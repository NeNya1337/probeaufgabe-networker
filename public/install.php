<?php

require_once("../lib/classes/db.inc.php");

$database = new Database();
$stmt = file_get_contents("../config/db.sql");
if($database->importDB($stmt)){
    echo "DB successfully imported";
}