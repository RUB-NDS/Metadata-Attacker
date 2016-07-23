<?php

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
    protected $encodingTool; // TODO: Sinnvoll? Video dadurch noch abspielbar?
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
        $this->setAlbum("Standard");

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
            else if(strpos($entry, 'Atom "tmpo"') !== false)    // TODO: Artwork as URL? FILE-URL?
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

        if($success !== false)
            return true;

        return false;
    }

    // Helper functions

    /**
     * Creates a string to set all given or selected metadata to the file.
     *
     * @return string
     */
    protected function getMetadataBag() {
        $metadataBag = "";

        if($this->artist        != null) $metadataBag .=    " --artist '"       . $this->artist         . "'";
        if($this->title         != null) $metadataBag .=    " --title '"        . $this->title          . "'";
        if($this->album         != null) $metadataBag .=    " --album '"        . $this->album          . "'";
        if($this->genre         != null) $metadataBag .=    " --genre '"        . $this->genre          . "'";
        if($this->tracknum      != null) $metadataBag .=    " --tracknum '"     . $this->tracknum       . "'";
        if($this->disk          != null) $metadataBag .=    " --disk '"         . $this->disk           . "'";
        if($this->comment       != null) $metadataBag .=    " --comment '"      . $this->comment        . "'";
        if($this->year          != null) $metadataBag .=    " --year '"         . $this->year           . "'";
        if($this->lyrics        != null) $metadataBag .=    " --lyrics '"       . $this->lyrics         . "'";
//        if($this->lyricsFile    != null) $metadataBag .=    " --lyricsFile '"   . $this->lyricsFile     . "'";
        if($this->composer      != null) $metadataBag .=    " --composer '"     . $this->composer       . "'";
        if($this->copyright     != null) $metadataBag .=    " --copyright '"    . $this->copyright      . "'";
//        if($this->grouping      != null) $metadataBag .=    " --grouping '"     . $this->grouping       . "'";
//        if($this->artwork       != null) $metadataBag .=    " --artwork '"      . $this->artwork        . "'";
        if($this->bpm           != null) $metadataBag .=    " --bpm '"          . $this->bpm            . "'";
        if($this->albumArtist   != null) $metadataBag .=    " --albumArtist '"  . $this->albumArtist    . "'";
        if($this->compilation   != null) $metadataBag .=    " --compilation '"  . $this->compilation    . "'";
        if($this->hdvideo       != null) $metadataBag .=    " --hdvideo '"      . $this->hdvideo        . "'";
        if($this->advisory      != null) $metadataBag .=    " --advisory '"     . $this->advisory       . "'";
        if($this->stik          != null) $metadataBag .=    " --stik '"         . $this->stik           . "'";
        if($this->description   != null) $metadataBag .=    " --description '"  . $this->description    . "'";
        if($this->longdesc      != null) $metadataBag .=    " --longdesc '"     . $this->longdesc       . "'";
        if($this->storedesc     != null) $metadataBag .=    " --storedesc '"    . $this->storedesc      . "'";
        if($this->TVNetwork     != null) $metadataBag .=    " --TVNetwork '"    . $this->TVNetwork      . "'";
        if($this->TVShowName    != null) $metadataBag .=    " --TVShowName '"   . $this->TVShowName     . "'";
        if($this->TVEpisode     != null) $metadataBag .=    " --TVEpisode '"    . $this->TVEpisode      . "'";
        if($this->TVSeasonNum   != null) $metadataBag .=    " --TVSeasonNum '"  . $this->TVSeasonNum    . "'";
        if($this->TVEpisodeNum  != null) $metadataBag .=    " --TVEpisodeNum '" . $this->TVEpisodeNum   . "'";
        if($this->podcastFlag   != null) $metadataBag .=    " --podcastFlag '"  . $this->podcastFlag    . "'";
        if($this->category      != null) $metadataBag .=    " --category '"     . $this->category       . "'";
        if($this->keyword       != null) $metadataBag .=    " --keyword '"      . $this->keyword        . "'";
        if($this->podcastURL    != null) $metadataBag .=    " --podcastURL '"   . $this->podcastURL     . "'";
        if($this->podcastGUID   != null) $metadataBag .=    " --podcastGUID '"  . $this->podcastGUID    . "'";
        if($this->purchaseDate  != null) $metadataBag .=    " --purchaseDate '" . $this->purchaseDate   . "'";
        if($this->encodingTool  != null) $metadataBag .=    " --encodingTool '" . $this->encodingTool   . "'";
        if($this->encodedBy     != null) $metadataBag .=    " --encodedBy '"    . $this->encodedBy      . "'";
        if($this->apID          != null) $metadataBag .=    " --apID '"         . $this->apID           . "'";
        if($this->cnID          != null) $metadataBag .=    " --cnID '"         . $this->cnID           . "'";
        if($this->geID          != null) $metadataBag .=    " --geID '"         . $this->geID           . "'";
        if($this->xID           != null) $metadataBag .=    " --xID '"          . $this->xID            . "'";
        if($this->gapless       != null) $metadataBag .=    " --gapless '"      . $this->gapless        . "'";
        if($this->contentRating != null) $metadataBag .=    " --contentRating '". $this->contentRating  . "'";

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

        return "/var/www/attacker/web/video/5min.mp4";
    }

    /**
     * Returns the full filepath to the temporary file.
     *
     * @return string
     */
    public function getFullFilepath() {
        return AtomicParsleyFile::filepath . $this->filename;
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