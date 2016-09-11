<?php
    require "../../vendor/autoload.php";

    $payload = "'';!--\"<XSS>=&{()}";
    $video = new AtomicParsleyFile();

    if(isset($_POST["videoPayload"]) && !empty($_POST["videoPayload"]))
        $payload = $_POST["videoPayload"];

    if(isset($_POST["length"]) && $_POST["length"] == "long")
        $video->setShort(false);

    foreach($_POST["fields"] as $field) {
        switch ($field) {
            case "artist":          $video->setArtist($payload);        break;
            case "title" :          $video->setTitle($payload);         break;
            case "album" :          $video->setAlbum($payload);         break;
            case "genre" :          $video->setGenre($payload);         break;
            case "comment":         $video->setComment($payload);       break;
            case "year" :           $video->setYear($payload);          break;
            case "lyrics":          $video->setLyrics($payload);        break;
            case "composer":        $video->setComposer($payload);      break;
            case "copyright":       $video->setCopyright($payload);     break;
            case "albumArtist":     $video->setAlbumArtist($payload);   break;
            case "description":     $video->setDescription($payload);   break;
            case "TVNetwork":       $video->setTVNetwork($payload);     break;
            case "TVShowName":      $video->setTVShowName($payload);    break;
            case "TVEpisode":       $video->setTVEpisode($payload);     break;
            case "category":        $video->setCategory($payload);      break;
            case "keyword":         $video->setKeyword($payload);       break;
            case "podcastURL":      $video->setPodcastURL($payload);    break;
            case "podcastGUID":     $video->setPodcastGUID($payload);   break;
            case "purchaseDate":    $video->setPurchaseDate($payload);  break;
            case "encodingTool":    $video->setEncodingTool($payload);  break;
            case "encodedBy":       $video->setEncodedBy($payload);     break;
            case "apID":            $video->setApID($payload);          break;
            case "xID":             $video->setXID($payload);           break;
            case "longdesc":        $video->setLongdesc($payload);      break;
            case "storedesc":       $video->setStoredesc($payload);     break;
        }
    };

// TODO: Error if only deactivated fields are used.

    if ( $video->save() ) {
        $video->download();
    }
    else {
        echo "A critical error occured. Please go back and try again.";
    }
