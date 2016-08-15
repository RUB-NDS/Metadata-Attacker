<?php
    require "../../vendor/autoload.php";

    setlocale(LC_CTYPE, "en_US.UTF-8");
    $content = file_get_contents("./xss.txt");

    $testvideo = new AtomicParsleyFile();
    $testvideo->setShort(true);
    $testvideo->setTitle("Sascha");
    $testvideo->setLongdesc($content);

    if ( $testvideo->save() ) {
        $testvideo->download();
    }

    echo "Es ist ein Fehler aufgetreten.";
//    AtomicParsleyFile::printMaxFieldValueSizesTable();
