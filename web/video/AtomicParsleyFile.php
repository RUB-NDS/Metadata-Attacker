<?php

class AtomicParsleyFile
{
    const filepath = "/tmp/Metadata-Attacker/";

    protected $filename;
    protected $short;

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

    /**
     * AtomicParsleyFile constructor.
     *
     * @param bool $short for the 30 sec video. Otherwise the 5 min video would be used.
     */
    public function __construct($short = true)
    {
        $this->short = $short;
        $this->filename = md5(microtime()) . ".mp4";
    }

    /**
     * Saves the configured dummy video in the $filepath folder with the Metadata.
     *
     * @return bool
     */
    public function save() {
        if(! file_exists(AtomicParsleyFile::filepath))
            mkdir(AtomicParsleyFile::filepath);

        if(file_put_contents(AtomicParsleyFile::filepath . $this->filename, $this->getTestfile()) !== false)
            return true;

        return false;
    }

    /**
     * Returnes the correct video dummy file for the selected size.
     *
     * @return string
     */
    public function getTestfile() {
        if($this->isShort())
            return file_get_contents("web/video/30sec.mp4");

        return file_get_contents("web/video/5min.mp4");
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
     * @return boolean
     */
    public function isShort()
    {
        return $this->short;
    }

}