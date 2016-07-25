<?php
    require "../../vendor/autoload.php";

    $testvideo = new AtomicParsleyFile();
    $testvideo->setShort(true);
    $testvideo->setTitle("';alert(String.fromCharCode(88,83,83))//';alert(String.fromCharCode(88,83,83))//\";
alert(String.fromCharCode(88,83,83))//\";alert(String.fromCharCode(88,83,83))//--");
    $testvideo->save();
    $testvideo->download();



