<?php
namespace Lednerb;

class AtomicParsleyFile
{
    protected $filename;

    // Possible Metadata from AtomicParsley
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


  // Setters
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



}