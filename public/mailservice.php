<?php
/**
 * @author: Mark Lösche
 * @mail: nenya1337@gmail.com
 * @date: Oct 9, 2022
 *
 * This page gets loaded from the email, asking for confirmation
 * */

require_once("../lib/classes/db.inc.php");

$template_dir = "../templates/";
$database = new Database();

if(isset($_GET["delete"]) && isset($_GET["hash"])) {
    switch ($_GET["delete"]) {
        case "no":
            $html = file_get_contents($template_dir . "confirm.html");
            break;
        case "yes" :
            $html = file_get_contents($template_dir . "decline.html");
            break;
        default:
            $html = file_get_contents($template_dir . "error.html");
            $text = "Da ist etwas schiefgegangen.";
            break;
    }
    $name = $database->getName($_GET["hash"])["name"];
    $html = str_replace("%NAME%", $name, $html);
    $html = str_replace("%HASHVALUE%", $_GET["hash"], $html);
    $html = str_replace("%DELETEVALUE%", $_GET["delete"], $html);
    echo $html;
}