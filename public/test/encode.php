<?php
$csv = fopen("CRM-Adresse.csv", "r");
$line = fgetcsv($csv, null, ";");
while(($line = fgetcsv($csv, null, ";")) !== FALSE){
        echo mb_convert_encoding($line[0],
                "UTF-8",
                mb_detect_encoding($line[0],["ISO-8859-1", "UTF-8"], false)
            )." - ".mb_convert_encoding($line[1], "UTF-8", mb_detect_encoding($line[1],["ISO-8859-1", "UTF-8"], false))."\n";

}

