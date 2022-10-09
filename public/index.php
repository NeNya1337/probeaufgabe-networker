<?php
    /**
     * @author: Mark Lösche
     * @mail: nenya1337@gmail.com
     * @date: Oct 9, 2022
     *
     * main page
     * */
?>
<!doctype html>
<html lang="de">
<head>
    <?php
    require_once("../lib/classes/db.inc.php");
    require_once("../lib/classes/hash.inc.php");
    require_once("../lib/classes/Data.inc.php");
    $template_dir = "../templates/";
    $database = new Database();
    $hash = new Hash();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datenimport</title>
    <style>
        #csvfile {
            display: none;
        }
        body {
            background-color: #bbcadd;
            background-image: url(assets/hintergrund.png) !important;
            background-size: cover;
        }
        .content-item {
            text-align: center;
        }
        body {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            height: 100vh;
        }


        form {
            margin-bottom: 0;
        }
        a {
            color: white;
            text-decoration: none;
        }
        button,
        .button {
            background-color: rgba(12, 83, 107, 0.82);
        }
        div.loading,
        div.success{
            background-color: rgba(76, 175, 80, 0.82);
        }
        div.loading,
        div.success,
        .button,
        button {
            color: white;
            width: 20em;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;

        }
        div.loading,
        div.success,
        .button {
            padding: 15px 32px;
            margin: 4px 2px;
        }
        form button {
            background: none;
        }
        button:hover,
        .button:hover,
        .button:hover *{
            background-color: white;
            color: black;
        }
        .success,
        .loading {
            display: none !important;
        }
        body > div:last-of-type {
            display: initial !important;
        }
    </style>
    <script>
        window.onload = function () {
            document.querySelector("#uploadbutton").addEventListener('mousedown', function(){document.querySelector("#csvfile").click(); });
        }
    </script>
</head>
<body>
<form action="/" id="csv_import" method="post" enctype="multipart/form-data">
        <div>
            <div class="button" id="uploadbutton">
                <label for="csvfile">
                    Datei auswählen
                    <input id="csvfile" class='content-item' type="file" name="csvfile" required="required">
                </label>
            </div>
        </div>
    <div>
        <div class="button">
            <button class='content-item' type="submit">Senden</button>
        </div>
    </div>
</form>
<form class='content-item' action="/" id="csv_export" method="post">
    <input type="hidden" name="export" value="1">

    <div class="button">
        <button type="submit">exportieren</button>
    </div>
    <?php
    //export function
    if(isset($_REQUEST["export"])){
        $data = $database->exportData();
        $date = date("Y-m-d-H-i-s");
        //add a time string to the file and put it into a file
        $export = fopen("exports/".$date."export.csv", "w");
        foreach ($data as $item) {
            fputcsv($export, $item);
        }
        fclose($export);
        //start the download (via popup)
        echo "<script>window.open('exports/".$date."export.csv', '_blank');</script>";
    }
    ?>
</form>

</body>
</html>

<?php
//check if CSV is given, then parse it
if(isset($_FILES["csvfile"])){
    $csv = fopen($_FILES["csvfile"]["tmp_name"], "r");
    $line = fgetcsv($csv, null, ";");
    $database->clearTable();
    echo "<div class='loading'>wird geladen...</div>";

    $successfulUploads = 0;
    while(($line = fgetcsv($csv, null, ";")) !== FALSE){
        $hashCode = $hash->getHash(60);
        //as example data wer given in ISO-8859-1, convert them to UFT-8 to ensure umlauts
        $line[0] = mb_convert_encoding($line[0], "UTF-8", mb_detect_encoding($line[0],["ISO-8859-1", "UTF-8"], false));
        $line[1] = mb_convert_encoding($line[1], "UTF-8", mb_detect_encoding($line[1],["ISO-8859-1", "UTF-8"], false));

        $data = new Data($line[0], $line[1], $hashCode);
        //import the data into database, when successful, build the mail
        if($database->importData($data)){
            $mail = file_get_contents($template_dir."email.html");
            $mail = str_replace("%NAME%", $data->getName(), $mail);
            $getstring = "hash=".$data->getHashCode()."&delete=";
            $mail = str_replace("%GETSTRINGSTAY%", $getstring."no",$mail);
            $mail = str_replace("%GETSTRINGDELETE%", $getstring."yes",$mail);
            $to = $data->getMail();
            if(!filter_var($to, FILTER_VALIDATE_EMAIL)){
                $to = idn_to_ascii($to,IDNA_NONTRANSITIONAL_TO_ASCII,INTL_IDNA_VARIANT_UTS46);
            }
            $subject = "testmail";
            $message = $mail;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: info@application.networker.info" . "\r\n";
            $headers .= "Reply-To: info@application.networker.info" . "\r\n";
            $headers .= "Return-Path: info@application.networker.info";
            if(mail($to,$subject,$message, $headers, "-f info@application.networker.info")){
                $successfulUploads++;
            }
        }
    }
    //print out, how many mails were sent
    echo "<div class='success'>$successfulUploads Mails wurden erfolgreich versendet.</div>";

}



