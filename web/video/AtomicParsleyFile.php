<?php

// TODO: Beim Einlesen auf UTF-16 achten!

class AtomicParsleyFile
{
    const filepath = "/tmp/Metadata-Attacker/";

    protected $filename;
    protected $short = true;

    // Possible Metadata from AtomicParsley.
    protected $artist;
    protected $title;
    protected $album;
    protected $genre;
    protected $tracknum;
    protected $disk;
    protected $comment;
    protected $year;
    protected $lyrics;
    protected $lyricsFile;
    protected $composer;
    protected $copyright;
    protected $grouping;
    protected $artwork;
    protected $bpm;
    protected $albumArtist;
    protected $compilation;
    protected $hdvideo;
    protected $advisory;
    protected $stik;
    protected $description;
    protected $longdesc;
    protected $storedesc;
    protected $TVNetwork;
    protected $TVShowName;
    protected $TVEpisode;
    protected $TVSeasonNum;
    protected $TVEpisodeNum;
    protected $podcastFlag;
    protected $category;
    protected $keyword;
    protected $podcastURL;
    protected $podcastGUID;
    protected $purchaseDate;
    protected $encodingTool;
    protected $encodedBy;
    protected $apID;
    protected $cnID;
    protected $geID;
    protected $xID;
    protected $gapless;
    protected $contentRating;

    /**
     * AtomicParsleyFile constructor.
     *
     */
    public function __construct($loadFileFromPath = null)
    {
        $this->filename = md5(microtime()) . ".mp4";
        // TODO: Remove Standard value / ERROR if missing :-(
        $this->setEncodedBy("Metadata-Attacker");

        // Load file information if a file is specified.
        if($loadFileFromPath != null) {
            if(file_exists($loadFileFromPath)) {
                if(is_file($loadFileFromPath)) {
                    // Set all metadata
                    $this->filename = substr($loadFileFromPath, strrpos($loadFileFromPath, "/") + 1);
                    $this->readMetadata();
                }
                else
                    throw new ErrorException("The given $loadFileFromPath is a directory");
            }
            else
                throw new ErrorException("The given file does not exist.");
        }

    }

    /**
     * Reads all given metadata via AtomicParsley from file and sets the variables.
     */
    public function readMetadata() {
        // Liefert lange Liste von Codeausgabe
        exec("AtomicParsley " . $this->getFullFilepath() . " -t", $atomicParsleyReturns);

        foreach ($atomicParsleyReturns as $entry) {
            if(strpos($entry, 'Atom "©ART"') !== false)
                $this->setArtist(substr($entry, 23));
            else if(strpos($entry, 'Atom "©nam"') !== false)
                $this->setTitle(substr($entry, 23));
            else if(strpos($entry, 'Atom "©alb"') !== false)
                $this->setAlbum(substr($entry, 23));
            else if(strpos($entry, 'Atom "©gen"') !== false)
                $this->setGenre(substr($entry, 23));
            else if(strpos($entry, 'Atom "trkn"') !== false)
                $this->setTracknum(substr($entry, 22));     // TODO: max. values? 45575 of 25614 from 111111/222222
            else if(strpos($entry, 'Atom "disk"') !== false)
                $this->setDisk(substr($entry, 22));     // TODO: wieso 22? // TODO: max. values? 5653 of 51228 from 333333/444444
            else if(strpos($entry, 'Atom "©gen"') !== false)
                $this->setGenre(substr($entry, 23));
            else if(strpos($entry, 'Atom "©cmt"') !== false)
                $this->setComment(substr($entry, 23));
            else if(strpos($entry, 'Atom "©day"') !== false)    // TODO: Check @day == year ???
                $this->setYear(substr($entry, 23));
            else if(strpos($entry, 'Atom "©lyr"') !== false)
                $this->setLyrics(substr($entry, 23));
            else if(strpos($entry, 'Atom "©wrt"') !== false)
                $this->setComposer(substr($entry, 23));
            else if(strpos($entry, 'Atom "cprt"') !== false)
                $this->setCopyright(substr($entry, 22));
            else if(strpos($entry, 'Atom "©grp"') !== false)
                $this->setGrouping(substr($entry, 23));
            else if(strpos($entry, 'Atom "covr"') !== false)    // TODO: Artwork as URL? FILE-URL?
                $this->setArtwork(substr($entry, 23));
            else if(strpos($entry, 'Atom "tmpo"') !== false)
                $this->setBpm(substr($entry, 22));
            else if(strpos($entry, 'Atom "aART"') !== false)
                $this->setAlbumArtist(substr($entry, 22));
            else if(strpos($entry, 'Atom "cpil"') !== false)
                $this->setCompilation((boolean) substr($entry, 22));
            else if(strpos($entry, 'Atom "hdvd"') !== false)
                $this->setHdvideo((boolean) substr($entry, 22));
            else if(strpos($entry, 'Atom "rtng"') !== false)
                $this->setAdvisory(substr($entry, 22));
            else if(strpos($entry, 'Atom "stik"') !== false)
                $this->setStik(substr($entry, 22));
            else if(strpos($entry, 'Atom "desc"') !== false)
                $this->setDescription(substr($entry, 22));
            else if(strpos($entry, 'Atom "ldes"') !== false)
                $this->setLongdesc(substr($entry, 22));
            else if(strpos($entry, 'Atom "sdes"') !== false)
                $this->setStoredesc(substr($entry, 22));
            else if(strpos($entry, 'Atom "tvnn"') !== false)
                $this->setTVNetwork(substr($entry, 22));
            else if(strpos($entry, 'Atom "tvsh"') !== false)
                $this->setTVShowName(substr($entry, 22));
            else if(strpos($entry, 'Atom "tven"') !== false)
                $this->setTVEpisode(substr($entry, 22));
            else if(strpos($entry, 'Atom "tvsn"') !== false)
                $this->setTVSeasonNum(substr($entry, 22));      // TODO: max. value? 56881? 777777 set
            else if(strpos($entry, 'Atom "tves"') !== false)
                $this->setTVEpisodeNum(substr($entry, 22));     // TODO: max. value? 36920? 888888 set
            else if(strpos($entry, 'Atom "pcst"') !== false)
                $this->setPodcastFlag((boolean) substr($entry, 22));      // TODO: only boolean?
            else if(strpos($entry, 'Atom "catg"') !== false)
                $this->setCategory(substr($entry, 22));
            else if(strpos($entry, 'Atom "keyw"') !== false)
                $this->setKeyword(substr($entry, 22));
            else if(strpos($entry, 'Atom "purl"') !== false)
                $this->setPodcastURL(substr($entry, 22));
            else if(strpos($entry, 'Atom "egid"') !== false)
                $this->setPodcastGUID(substr($entry, 22));
            else if(strpos($entry, 'Atom "purd"') !== false)
                $this->setPurchaseDate(substr($entry, 22));
            else if(strpos($entry, 'Atom "©too"') !== false)
                $this->setEncodingTool(substr($entry, 26));
            else if(strpos($entry, 'Atom "©enc"') !== false)
                $this->setEncodedBy(substr($entry, 23));
            else if(strpos($entry, 'Atom "apID"') !== false)
                $this->setApID(substr($entry, 22));
            else if(strpos($entry, 'Atom "apID"') !== false)
                $this->setApID(substr($entry, 22));
            else if(strpos($entry, 'Atom "cnID"') !== false)
                $this->setCnID(substr($entry, 22));
            else if(strpos($entry, 'Atom "geID"') !== false)
                $this->setGeID(substr($entry, 22));
            else if(strpos($entry, 'Atom "xid "') !== false)
                $this->setXID(substr($entry, 22));
            else if(strpos($entry, 'Atom "pgap"') !== false)
                $this->setGapless((boolean) substr($entry, 22));     // TODO: only boolean?
            else if(strpos($entry, 'Atom "----"') !== false)
                $this->setContentRating(substr($entry, 12));     // TODO: only boolean?
        }
    }

    /**
     * Saves the configured dummy video in the $filepath folder with the Metadata.
     *
     * @return bool
     */
    public function save() {
        if(! file_exists(AtomicParsleyFile::filepath))
            mkdir(AtomicParsleyFile::filepath);

        $success = exec("AtomicParsley " .
            $this->getTestfile() .
            $this->getMetadataBag() .
            " -o " . $this->getFullFilepath()
        );

        if(($success !== false) && filesize($this->getFullFilepath()) > 100)
            return true;

        return false;
    }

    /**
     * Returns the video to download in the browser.
     */
    public function download() {
        header("Content-type: video/mp4");
        header("Content-Disposition:attachment;filename=\"" . $this->getFilename() ."\"");
        header("Content-length: " . filesize($this->getFullFilepath()) . "\n\n");
        echo file_get_contents($this->getFullFilepath());
    }

    // Helper functions

    /**
     * Creates a string to set all given or selected metadata to the file.
     *
     * @return string
     */
    protected function getMetadataBag() {
        $metadataBag = "";

        if($this->artist        != null) $metadataBag .=    " --artist "        . escapeshellarg($this->artist);
        if($this->title         != null) $metadataBag .=    " --title "         . escapeshellarg($this->title);
        if($this->album         != null) $metadataBag .=    " --album "         . escapeshellarg($this->album);
        if($this->genre         != null) $metadataBag .=    " --genre "         . escapeshellarg($this->genre);
        if($this->tracknum      != null) $metadataBag .=    " --tracknum "      . escapeshellarg($this->tracknum);
        if($this->disk          != null) $metadataBag .=    " --disk "          . escapeshellarg($this->disk           );
        if($this->comment       != null) $metadataBag .=    " --comment "       . escapeshellarg($this->comment        );
        if($this->year          != null) $metadataBag .=    " --year "          . escapeshellarg($this->year           );
        if($this->lyrics        != null) $metadataBag .=    " --lyrics "        . escapeshellarg($this->lyrics         );
//        if($this->lyricsFile    != null) $metadataBag .=    " --lyricsFile '"   . $this->lyricsFile     . "'";
        if($this->composer      != null) $metadataBag .=    " --composer "      . escapeshellarg($this->composer       );
        if($this->copyright     != null) $metadataBag .=    " --copyright "     . escapeshellarg($this->copyright      );
//        if($this->grouping      != null) $metadataBag .=    " --grouping '"     . $this->grouping       . "'";
//        if($this->artwork       != null) $metadataBag .=    " --artwork '"      . $this->artwork        . "'";
        if($this->bpm           != null) $metadataBag .=    " --bpm "           . escapeshellarg($this->bpm            );
        if($this->albumArtist   != null) $metadataBag .=    " --albumArtist "   . escapeshellarg($this->albumArtist    );
        if($this->compilation   != null) $metadataBag .=    " --compilation "   . escapeshellarg($this->compilation    );
        if($this->hdvideo       != null) $metadataBag .=    " --hdvideo "       . escapeshellarg($this->hdvideo        );
        if($this->advisory      != null) $metadataBag .=    " --advisory "      . escapeshellarg($this->advisory       );
        if($this->stik          != null) $metadataBag .=    " --stik "          . escapeshellarg($this->stik           );
        if($this->description   != null) $metadataBag .=    " --description "   . escapeshellarg($this->description    );
        if($this->longdesc      != null) $metadataBag .=    " --longdesc "      . escapeshellarg($this->longdesc       );
        if($this->storedesc     != null) $metadataBag .=    " --storedesc "     . escapeshellarg($this->storedesc      );
        if($this->TVNetwork     != null) $metadataBag .=    " --TVNetwork "     . escapeshellarg($this->TVNetwork      );
        if($this->TVShowName    != null) $metadataBag .=    " --TVShowName "    . escapeshellarg($this->TVShowName     );
        if($this->TVEpisode     != null) $metadataBag .=    " --TVEpisode "     . escapeshellarg($this->TVEpisode      );
        if($this->TVSeasonNum   != null) $metadataBag .=    " --TVSeasonNum "   . escapeshellarg($this->TVSeasonNum    );
        if($this->TVEpisodeNum  != null) $metadataBag .=    " --TVEpisodeNum "  . escapeshellarg($this->TVEpisodeNum   );
        if($this->podcastFlag   != null) $metadataBag .=    " --podcastFlag "   . escapeshellarg($this->podcastFlag    );
        if($this->category      != null) $metadataBag .=    " --category "      . escapeshellarg($this->category       );
        if($this->keyword       != null) $metadataBag .=    " --keyword "       . escapeshellarg($this->keyword        );
        if($this->podcastURL    != null) $metadataBag .=    " --podcastURL "    . escapeshellarg($this->podcastURL     );
        if($this->podcastGUID   != null) $metadataBag .=    " --podcastGUID "   . escapeshellarg($this->podcastGUID    );
        if($this->purchaseDate  != null) $metadataBag .=    " --purchaseDate "  . escapeshellarg($this->purchaseDate   );
        if($this->encodingTool  != null) $metadataBag .=    " --encodingTool "  . escapeshellarg($this->encodingTool   );
        if($this->encodedBy     != null) $metadataBag .=    " --encodedBy "     . escapeshellarg($this->encodedBy      );
        if($this->apID          != null) $metadataBag .=    " --apID "          . escapeshellarg($this->apID           );
        if($this->cnID          != null) $metadataBag .=    " --cnID "          . escapeshellarg($this->cnID           );
        if($this->geID          != null) $metadataBag .=    " --geID "          . escapeshellarg($this->geID           );
        if($this->xID           != null) $metadataBag .=    " --xID "           . escapeshellarg($this->xID            );
        if($this->gapless       != null) $metadataBag .=    " --gapless "       . escapeshellarg($this->gapless        );
        if($this->contentRating != null) $metadataBag .=    " --contentRating " . escapeshellarg($this->contentRating  );

        return $metadataBag;
    }

    /**
     * Returnes the correct video dummy file for the selected size.
     *
     * @return string
     */
    public function getTestfile() {
        if($this->isShort())
            return "/var/www/attacker/web/video/30sec.mp4";

        return "/var/www/attacker/web/video/10min.mp4";
    }

    /**
     * Returns the full filepath to the temporary file.
     *
     * @return string
     */
    public function getFullFilepath() {
        return AtomicParsleyFile::filepath . $this->filename;
    }

    /**
     * Deletes a saved file.
     *
     * @return bool
     */
    public function delete(){
        if(file_exists($this->getFullFilepath()))
            if(unlink($this->getFullFilepath()))
                return true;

        return false;
    }

    /**
     * Simple fuzzer to determine the length of a given field.
     *
     * @param $length
     * @return string
     */
    public static function fuzzer($length) {
        $string = "";
        for ($i=1; $i <= $length; $i++)
            $string .= "A";
        return $string;
    }

    /**
     * Test how many characters the given field can save with AtomicParsley.
     *
     * @param $fieldname
     * @return int
     */
    public static function getMaxLengthOfField($fieldname) {
        $counter = 0;
        $setMethod = "set" . ucfirst($fieldname);
        $getMethod = "get" . ucfirst($fieldname);

        if (ucfirst($fieldname) == "Longdesc") $counter = 130924;

        do {
            $counter++;
            $file = new AtomicParsleyFile();
            $file->$setMethod(self::fuzzer($counter));
            $file->save();

            $loadedFile = new AtomicParsleyFile($file->getFullFilepath());
            $file->delete();
        } while (strcmp($file->$getMethod(), $loadedFile->$getMethod()) == 0);

        return $counter - 1;
    }

    public static function printMaxFieldValueSizesTable() {
        $output = "<table class='table table-hover'>";
        $output .= "<tr><th>Fieldname</th><th>Command Argument</th><th>Max Size in Chars</th></tr>";
        $output .= "<tr><td>Artist</td><td>--artist</td><td>" .self::getMaxLengthOfField("artist") . "</td></tr>";
        $output .= "<tr><td>Title</td><td>--title</td><td>" .self::getMaxLengthOfField("Title") . "</td></tr>";
        $output .= "<tr><td>Album</td><td>--album</td><td>" .self::getMaxLengthOfField("Album") . "</td></tr>";
        $output .= "<tr><td>Genre</td><td>--genre</td><td>" .self::getMaxLengthOfField("Genre") . "</td></tr>";
        $output .= "<tr><td>Tracknum</td><td>--tracknum</td><td>" .self::getMaxLengthOfField("Tracknum") . "</td></tr>";
        $output .= "<tr><td>Disk</td><td>--disk</td><td>" .self::getMaxLengthOfField("Disk") . "</td></tr>";
        $output .= "<tr><td>Comment</td><td>--comment</td><td>" .self::getMaxLengthOfField("Comment") . "</td></tr>";
        $output .= "<tr><td>Year</td><td>--year</td><td>" .self::getMaxLengthOfField("Year") . "</td></tr>";
        $output .= "<tr><td>Composer</td><td>--composer</td><td>" .self::getMaxLengthOfField("Composer") . "</td></tr>";
        $output .= "<tr><td>Copyright</td><td>--copyright</td><td>" .self::getMaxLengthOfField("Copyright") . "</td></tr>";
        $output .= "<tr><td>Bpm</td><td>--bpm</td><td>" .self::getMaxLengthOfField("Bpm") . "</td></tr>";
        $output .= "<tr><td>AlbumArtist</td><td>--albumArtist</td><td>" .self::getMaxLengthOfField("AlbumArtist") . "</td></tr>";
        $output .= "<tr><td>Compilation</td><td>--compilation</td><td>" .self::getMaxLengthOfField("Compilation") . "</td></tr>";
        $output .= "<tr><td>Hdvideo</td><td>--hdvideo</td><td>" .self::getMaxLengthOfField("Hdvideo") . "</td></tr>";
        $output .= "<tr><td>Advisory</td><td>--advisory</td><td>" .self::getMaxLengthOfField("Advisory") . "</td></tr>";
        $output .= "<tr><td>Stik</td><td>--stik</td><td>" .self::getMaxLengthOfField("Stik") . "</td></tr>";
        $output .= "<tr><td>Description</td><td>--description</td><td>" .self::getMaxLengthOfField("Description") . "</td></tr>";
//        $output .= "<tr><td>Longdesc</td><td>--longdesc</td><td>" .self::getMaxLengthOfField("Longdesc") . "</td></tr>";
//        $output .= "<tr><td>Storedesc</td><td>--storedesc</td><td>" .self::getMaxLengthOfField("Storedesc") . "</td></tr>";
        $output .= "<tr><td>TVNetwork</td><td>--TVNetwork</td><td>" .self::getMaxLengthOfField("TVNetwork") . "</td></tr>";
        $output .= "<tr><td>TVShowName</td><td>--TVShowName</td><td>" .self::getMaxLengthOfField("TVShowName") . "</td></tr>";
        $output .= "<tr><td>TVEpisode</td><td>--TVEpisode</td><td>" .self::getMaxLengthOfField("TVEpisode") . "</td></tr>";
        $output .= "<tr><td>TVSeasonNum</td><td>--TVSeasonNum</td><td>" .self::getMaxLengthOfField("TVSeasonNum") . "</td></tr>";
        $output .= "<tr><td>TVEpisodeNum</td><td>--TVEpisodeNum</td><td>" .self::getMaxLengthOfField("TVEpisodeNum") . "</td></tr>";
        $output .= "<tr><td>PodcastFlag</td><td>--podcastFlag</td><td>" .self::getMaxLengthOfField("podcastFlag") . "</td></tr>";
        $output .= "<tr><td>Category</td><td>--category</td><td>" .self::getMaxLengthOfField("Category") . "</td></tr>";
        $output .= "<tr><td>Keyword</td><td>--keyword</td><td>" .self::getMaxLengthOfField("Keyword") . "</td></tr>";
        $output .= "<tr><td>PodcastURL</td><td>--podcastURL</td><td>" .self::getMaxLengthOfField("PodcastURL") . "</td></tr>";
        $output .= "<tr><td>PodcastGUID</td><td>--podcastGUID</td><td>" .self::getMaxLengthOfField("PodcastGUID") . "</td></tr>";
        $output .= "<tr><td>PurchaseDate</td><td>--purchaseDate</td><td>" .self::getMaxLengthOfField("PurchaseDate") . "</td></tr>";
        $output .= "<tr><td>EncodingTool</td><td>--encodingTool</td><td>" .self::getMaxLengthOfField("EncodingTool") . "</td></tr>";
        $output .= "<tr><td>EncodedBy</td><td>--encodedBy</td><td>" .self::getMaxLengthOfField("EncodedBy") . "</td></tr>";
        $output .= "<tr><td>apID</td><td>--apID</td><td>" .self::getMaxLengthOfField("apID") . "</td></tr>";
        $output .= "<tr><td>cnID</td><td>--cnID</td><td>" .self::getMaxLengthOfField("cnID") . "</td></tr>";
        $output .= "<tr><td>geID</td><td>--geID</td><td>" .self::getMaxLengthOfField("geID") . "</td></tr>";
        $output .= "<tr><td>xID</td><td>--xID</td><td>" .self::getMaxLengthOfField("xID") . "</td></tr>";
        $output .= "<tr><td>Gapless</td><td>--gapless</td><td>" .self::getMaxLengthOfField("Gapless") . "</td></tr>";
        $output .= "<tr><td>ContentRating</td><td>--contentRating</td><td>" .self::getMaxLengthOfField("ContentRating") . "</td></tr>";
        $output .= "</table>";

        echo $output;
    }

    // Simple Setters
    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @param mixed $tracknum
     */
    public function setTracknum($tracknum)
    {
        $this->tracknum = $tracknum;
    }

    /**
     * @param mixed $disk
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @param mixed $lyrics
     */
    public function setLyrics($lyrics)
    {
        $this->lyrics = $lyrics;
    }

    /**
     * @param mixed $lyricsFile
     */
    public function setLyricsFile($lyricsFile)
    {
        $this->lyricsFile = $lyricsFile;
    }

    /**
     * @param mixed $composer
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;
    }

    /**
     * @param mixed $copyright
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }

    /**
     * @param mixed $grouping
     */
    public function setGrouping($grouping)
    {
        $this->grouping = $grouping;
    }

    /**
     * @param mixed $artwork
     */
    public function setArtwork($artwork)
    {
        $this->artwork = $artwork;
    }

    /**
     * @param mixed $bpm
     */
    public function setBpm($bpm)
    {
        $this->bpm = $bpm;
    }

    /**
     * @param mixed $albumArtist
     */
    public function setAlbumArtist($albumArtist)
    {
        $this->albumArtist = $albumArtist;
    }

    /**
     * @param mixed $compilation
     */
    public function setCompilation($compilation)
    {
        $this->compilation = $compilation;
    }

    /**
     * @param mixed $hdvideo
     */
    public function setHdvideo($hdvideo)
    {
        $this->hdvideo = $hdvideo;
    }

    /**
     * @param mixed $advisory
     */
    public function setAdvisory($advisory)
    {
        $this->advisory = $advisory;
    }

    /**
     * @param mixed $stik
     */
    public function setStik($stik)
    {
        $this->stik = $stik;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $longdesc
     */
    public function setLongdesc($longdesc)
    {
        $this->longdesc = $longdesc;
    }

    /**
     * @param mixed $storedesc
     */
    public function setStoredesc($storedesc)
    {
        $this->storedesc = $storedesc;
    }

    /**
     * @param mixed $TVNetwork
     */
    public function setTVNetwork($TVNetwork)
    {
        $this->TVNetwork = $TVNetwork;
    }

    /**
     * @param mixed $TVShowName
     */
    public function setTVShowName($TVShowName)
    {
        $this->TVShowName = $TVShowName;
    }

    /**
     * @param mixed $TVEpisode
     */
    public function setTVEpisode($TVEpisode)
    {
        $this->TVEpisode = $TVEpisode;
    }

    /**
     * @param mixed $TVSeasonNum
     */
    public function setTVSeasonNum($TVSeasonNum)
    {
        $this->TVSeasonNum = $TVSeasonNum;
    }

    /**
     * @param mixed $TVEpisodeNum
     */
    public function setTVEpisodeNum($TVEpisodeNum)
    {
        $this->TVEpisodeNum = $TVEpisodeNum;
    }

    /**
     * @param mixed $podcastFlag
     */
    public function setPodcastFlag($podcastFlag)
    {
        $this->podcastFlag = $podcastFlag;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @param mixed $podcastURL
     */
    public function setPodcastURL($podcastURL)
    {
        $this->podcastURL = $podcastURL;
    }

    // Simple Getters
    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getTracknum()
    {
        return $this->tracknum;
    }

    /**
     * @return mixed
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getLyrics()
    {
        return $this->lyrics;
    }

    /**
     * @return mixed
     */
    public function getLyricsFile()
    {
        return $this->lyricsFile;
    }

    /**
     * @return mixed
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * @return mixed
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @return mixed
     */
    public function getGrouping()
    {
        return $this->grouping;
    }

    /**
     * @return mixed
     */
    public function getArtwork()
    {
        return $this->artwork;
    }

    /**
     * @return mixed
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * @return mixed
     */
    public function getAlbumArtist()
    {
        return $this->albumArtist;
    }

    /**
     * @return mixed
     */
    public function getCompilation()
    {
        return $this->compilation;
    }

    /**
     * @return mixed
     */
    public function getHdvideo()
    {
        return $this->hdvideo;
    }

    /**
     * @return mixed
     */
    public function getAdvisory()
    {
        return $this->advisory;
    }

    /**
     * @return mixed
     */
    public function getStik()
    {
        return $this->stik;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getLongdesc()
    {
        return $this->longdesc;
    }

    /**
     * @return mixed
     */
    public function getStoredesc()
    {
        return $this->storedesc;
    }

    /**
     * @return mixed
     */
    public function getTVNetwork()
    {
        return $this->TVNetwork;
    }

    /**
     * @return mixed
     */
    public function getTVShowName()
    {
        return $this->TVShowName;
    }

    /**
     * @return mixed
     */
    public function getTVEpisode()
    {
        return $this->TVEpisode;
    }

    /**
     * @return mixed
     */
    public function getTVSeasonNum()
    {
        return $this->TVSeasonNum;
    }

    /**
     * @return mixed
     */
    public function getTVEpisodeNum()
    {
        return $this->TVEpisodeNum;
    }

    /**
     * @return mixed
     */
    public function getPodcastFlag()
    {
        return $this->podcastFlag;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @return mixed
     */
    public function getPodcastURL()
    {
        return $this->podcastURL;
    }

    /**
     * @return mixed
     */
    public function getShort()
    {
        return $this->short;
    }

    /**
     * @param mixed $short
     */
    public function setShort($short)
    {
        $this->short = $short;
    }

    /**
     * @return boolean
     */
    public function isShort()
    {
        return $this->short;
    }

    /**
     * @return mixed
     */
    public function getPodcastGUID()
    {
        return $this->podcastGUID;
    }

    /**
     * @param mixed $podcastGUID
     */
    public function setPodcastGUID($podcastGUID)
    {
        $this->podcastGUID = $podcastGUID;
    }

    /**
     * @return mixed
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * @param mixed $purchaseDate
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;
    }

    /**
     * @return mixed
     */
    public function getEncodingTool()
    {
        return $this->encodingTool;
    }

    /**
     * @param mixed $encodingTool
     */
    public function setEncodingTool($encodingTool)
    {
        $this->encodingTool = $encodingTool;
    }

    /**
     * @return mixed
     */
    public function getGapless()
    {
        return $this->gapless;
    }

    /**
     * @param mixed $gapless
     */
    public function setGapless($gapless)
    {
        $this->gapless = $gapless;
    }

    /**
     * @return mixed
     */
    public function getContentRating()
    {
        return $this->contentRating;
    }

    /**
     * @param mixed $contentRating
     */
    public function setContentRating($contentRating)
    {
        $this->contentRating = $contentRating;
    }

    /**
     * @return mixed
     */
    public function getEncodedBy()
    {
        return $this->encodedBy;
    }

    /**
     * @param mixed $encodedBy
     */
    public function setEncodedBy($encodedBy)
    {
        $this->encodedBy = $encodedBy;
    }

    /**
     * @return mixed
     */
    public function getApID()
    {
        return $this->apID;
    }

    /**
     * @param mixed $apID
     */
    public function setApID($apID)
    {
        $this->apID = $apID;
    }

    /**
     * @return mixed
     */
    public function getCnID()
    {
        return $this->cnID;
    }

    /**
     * @param mixed $cnID
     */
    public function setCnID($cnID)
    {
        $this->cnID = $cnID;
    }

    /**
     * @return mixed
     */
    public function getGeID()
    {
        return $this->geID;
    }

    /**
     * @param mixed $geID
     */
    public function setGeID($geID)
    {
        $this->geID = $geID;
    }

    /**
     * @return mixed
     */
    public function getXID()
    {
        return $this->xID;
    }

    /**
     * @param mixed $xID
     */
    public function setXID($xID)
    {
        $this->xID = $xID;
    }



}