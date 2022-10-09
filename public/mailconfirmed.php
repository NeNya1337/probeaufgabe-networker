<?php

/**
 * @author: Mark Lösche
 * @mail: nenya1337@gmail.com
 * @date: Oct 9, 2022
 *
 * This page gets loaded after a user successfully accepted/declined being on the mailing list
 * */


require_once("../lib/classes/db.inc.php");

$template_dir = "../templates/";
$database = new Database();

$html = file_get_contents($template_dir."confirmed.html");

switch ($_POST["delete"]){
    case "no":
        $answer = 0;
        $text = "Vielen Dank, dass Sie weiter an unserem Erfolg teilhaben möchten.";
        break;
    case "yes" :
        $answer = 1;
        $text = "Sie wurden von der Mailingliste entfernt. Schade.";
        break;
    default:
        $answer = NULL;
        $text = "Da ist etwas schiefgegangen.";
        break;
}
if($answer !== NULL){
    $database->updatePreference($_POST["hash"], $answer);
    $html = str_replace("%TEXT%", $text, $html);

}

echo $html;
