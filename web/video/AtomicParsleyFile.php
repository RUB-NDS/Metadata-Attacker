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
    protected $comment;
    protected $year;
    protected $lyrics;
    protected $composer;
    protected $copyright;
    protected $grouping;
    protected $artwork;
    protected $albumArtist;
    protected $description;
    protected $longdesc;
    protected $storedesc;
    protected $TVNetwork;
    protected $TVShowName;
    protected $TVEpisode;
    protected $TVSeasonNum;
    protected $TVEpisodeNum;
    protected $category;
    protected $keyword;
    protected $purchaseDate;
    protected $encodingTool;
    protected $encodedBy;
    protected $apID;
    protected $xID;


    /**
     * AtomicParsleyFile constructor.
     *
     */
    public function __construct($loadFileFromPath = null)
    {
        $this->filename = md5(microtime()) . ".mp4";
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

        // Delete old files (older than 5 minutes)
        foreach (glob(AtomicParsleyFile::filepath."*") as $file)
            if (filemtime($file) < time() - 300)
                unlink($file);
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
            else if(strpos($entry, 'Atom "©gen"') !== false)
                $this->setGenre(substr($entry, 23));
            else if(strpos($entry, 'Atom "©cmt"') !== false)
                $this->setComment(substr($entry, 23));
            else if(strpos($entry, 'Atom "©day"') !== false)    
                $this->setYear(substr($entry, 23));
            else if(strpos($entry, 'Atom "©lyr"') !== false)
                $this->setLyrics(substr($entry, 23));
            else if(strpos($entry, 'Atom "©wrt"') !== false)
                $this->setComposer(substr($entry, 23));
            else if(strpos($entry, 'Atom "cprt"') !== false)
                $this->setCopyright(substr($entry, 22));
            else if(strpos($entry, 'Atom "aART"') !== false)
                $this->setAlbumArtist(substr($entry, 22));
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
            else if(strpos($entry, 'Atom "catg"') !== false)
                $this->setCategory(substr($entry, 22));
            else if(strpos($entry, 'Atom "keyw"') !== false)
                $this->setKeyword(substr($entry, 22));
            else if(strpos($entry, 'Atom "purd"') !== false)
                $this->setPurchaseDate(substr($entry, 22));
            else if(strpos($entry, 'Atom "©too"') !== false)
                $this->setEncodingTool(substr($entry, 26));
            else if(strpos($entry, 'Atom "©enc"') !== false)
                $this->setEncodedBy(substr($entry, 23));
            else if(strpos($entry, 'Atom "apID"') !== false)
                $this->setApID(substr($entry, 22));
            else if(strpos($entry, 'Atom "xid "') !== false)
                $this->setXID(substr($entry, 22));
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

        // First take the correct file and save it with the artwork
        $this->filename = md5(microtime()) . ".mp4";
        $success = exec("AtomicParsley " .
            $this->getTestfile() .
            " --artwork /var/www/attacker/web/video/artwork.jpg" .
            " -o " . $this->getFullFilepath()
        );
        if(($success !== false) && filesize($this->getFullFilepath()) > 100){

            foreach ($this->getMetadataBag() as $key => $value) {
                $oldFilepath = $this->getFullFilepath();
                $this->filename = md5(microtime()) . ".mp4";
                $success = exec("AtomicParsley " .
                    $oldFilepath .
                    $key . " " . $value .
                    // $key . " \"$(cat " . $dummyValueFilepath . ")\"".
                    " -o " . $this->getFullFilepath()
                );
                if ($success === false) 
                    return false;
            }

            return true;
        }


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
        $metadataBag = array();

        if($this->artist        != null) $metadataBag[" --artist "        ] =  escapeshellarg($this->artist);
        if($this->title         != null) $metadataBag[" --title "         ] =  escapeshellarg($this->title);
        if($this->album         != null) $metadataBag[" --album "         ] =  escapeshellarg($this->album);
        if($this->genre         != null) $metadataBag[" --genre "         ] =  escapeshellarg($this->genre);
        if($this->tracknum      != null) $metadataBag[" --tracknum "      ] =  escapeshellarg($this->tracknum);
        if($this->comment       != null) $metadataBag[" --comment "       ] =  escapeshellarg($this->comment        );
        if($this->year          != null) $metadataBag[" --year "          ] =  escapeshellarg($this->year           );
        if($this->lyrics        != null) $metadataBag[" --lyrics "        ] =  escapeshellarg($this->lyrics         );
        if($this->composer      != null) $metadataBag[" --composer "      ] =  escapeshellarg($this->composer       );
        if($this->copyright     != null) $metadataBag[" --copyright "     ] =  escapeshellarg($this->copyright      );
        if($this->albumArtist   != null) $metadataBag[" --albumArtist "   ] =  escapeshellarg($this->albumArtist    );
        if($this->description   != null) $metadataBag[" --description "   ] =  escapeshellarg($this->description    );
        if($this->longdesc      != null) $metadataBag[" --longdesc "      ] =  escapeshellarg($this->longdesc       );
        if($this->storedesc     != null) $metadataBag[" --storedesc "     ] =  escapeshellarg($this->storedesc      );
        if($this->TVNetwork     != null) $metadataBag[" --TVNetwork "     ] =  escapeshellarg($this->TVNetwork      );
        if($this->TVShowName    != null) $metadataBag[" --TVShowName "    ] =  escapeshellarg($this->TVShowName     );
        if($this->TVEpisode     != null) $metadataBag[" --TVEpisode "     ] =  escapeshellarg($this->TVEpisode      );
        if($this->TVSeasonNum   != null) $metadataBag[" --TVSeasonNum "   ] =  escapeshellarg($this->TVSeasonNum    );
        if($this->TVEpisodeNum  != null) $metadataBag[" --TVEpisodeNum "  ] =  escapeshellarg($this->TVEpisodeNum   );
        if($this->category      != null) $metadataBag[" --category "      ] =  escapeshellarg($this->category       );
        if($this->keyword       != null) $metadataBag[" --keyword "       ] =  escapeshellarg($this->keyword        );
        if($this->purchaseDate  != null) $metadataBag[" --purchaseDate "  ] =  escapeshellarg($this->purchaseDate   );
        if($this->encodingTool  != null) $metadataBag[" --encodingTool "  ] =  escapeshellarg($this->encodingTool   );
        if($this->encodedBy     != null) $metadataBag[" --encodedBy "     ] =  escapeshellarg($this->encodedBy      );
        if($this->apID          != null) $metadataBag[" --apID "          ] =  escapeshellarg($this->apID           );
        if($this->xID           != null) $metadataBag[" --xID "           ] =  escapeshellarg($this->xID            );

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
        $output .= "<tr><td>Comment</td><td>--comment</td><td>" .self::getMaxLengthOfField("Comment") . "</td></tr>";
        $output .= "<tr><td>Year</td><td>--year</td><td>" .self::getMaxLengthOfField("Year") . "</td></tr>";
        $output .= "<tr><td>Composer</td><td>--composer</td><td>" .self::getMaxLengthOfField("Composer") . "</td></tr>";
        $output .= "<tr><td>Copyright</td><td>--copyright</td><td>" .self::getMaxLengthOfField("Copyright") . "</td></tr>";
        $output .= "<tr><td>AlbumArtist</td><td>--albumArtist</td><td>" .self::getMaxLengthOfField("AlbumArtist") . "</td></tr>";
        $output .= "<tr><td>Description</td><td>--description</td><td>" .self::getMaxLengthOfField("Description") . "</td></tr>";
//        $output .= "<tr><td>Longdesc</td><td>--longdesc</td><td>" .self::getMaxLengthOfField("Longdesc") . "</td></tr>";
//        $output .= "<tr><td>Storedesc</td><td>--storedesc</td><td>" .self::getMaxLengthOfField("Storedesc") . "</td></tr>";
        $output .= "<tr><td>TVNetwork</td><td>--TVNetwork</td><td>" .self::getMaxLengthOfField("TVNetwork") . "</td></tr>";
        $output .= "<tr><td>TVShowName</td><td>--TVShowName</td><td>" .self::getMaxLengthOfField("TVShowName") . "</td></tr>";
        $output .= "<tr><td>TVEpisode</td><td>--TVEpisode</td><td>" .self::getMaxLengthOfField("TVEpisode") . "</td></tr>";
        $output .= "<tr><td>TVSeasonNum</td><td>--TVSeasonNum</td><td>" .self::getMaxLengthOfField("TVSeasonNum") . "</td></tr>";
        $output .= "<tr><td>TVEpisodeNum</td><td>--TVEpisodeNum</td><td>" .self::getMaxLengthOfField("TVEpisodeNum") . "</td></tr>";
        $output .= "<tr><td>Category</td><td>--category</td><td>" .self::getMaxLengthOfField("Category") . "</td></tr>";
        $output .= "<tr><td>Keyword</td><td>--keyword</td><td>" .self::getMaxLengthOfField("Keyword") . "</td></tr>";
        $output .= "<tr><td>PurchaseDate</td><td>--purchaseDate</td><td>" .self::getMaxLengthOfField("PurchaseDate") . "</td></tr>";
        $output .= "<tr><td>EncodingTool</td><td>--encodingTool</td><td>" .self::getMaxLengthOfField("EncodingTool") . "</td></tr>";
        $output .= "<tr><td>EncodedBy</td><td>--encodedBy</td><td>" .self::getMaxLengthOfField("EncodedBy") . "</td></tr>";
        $output .= "<tr><td>apID</td><td>--apID</td><td>" .self::getMaxLengthOfField("apID") . "</td></tr>";
        $output .= "<tr><td>xID</td><td>--xID</td><td>" .self::getMaxLengthOfField("xID") . "</td></tr>";
        $output .= "</table>";

        echo $output;
    }

    public function isShort() {
        return $this->short;
    }



    /**
     * Gets the value of filename.
     *
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Sets the value of filename.
     *
     * @param mixed $filename the filename
     *
     * @return self
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Gets the value of short.
     *
     * @return mixed
     */
    public function getShort()
    {
        return $this->short;
    }

    /**
     * Sets the value of short.
     *
     * @param mixed $short the short
     *
     * @return self
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Gets the value of artist.
     *
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Sets the value of artist.
     *
     * @param mixed $artist the artist
     *
     * @return self
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Gets the value of title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param mixed $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the value of album.
     *
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Sets the value of album.
     *
     * @param mixed $album the album
     *
     * @return self
     */
    public function setAlbum($album)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Gets the value of genre.
     *
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Sets the value of genre.
     *
     * @param mixed $genre the genre
     *
     * @return self
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Gets the value of comment.
     *
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the value of comment.
     *
     * @param mixed $comment the comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Gets the value of year.
     *
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the value of year.
     *
     * @param mixed $year the year
     *
     * @return self
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Gets the value of lyrics.
     *
     * @return mixed
     */
    public function getLyrics()
    {
        return $this->lyrics;
    }

    /**
     * Sets the value of lyrics.
     *
     * @param mixed $lyrics the lyrics
     *
     * @return self
     */
    public function setLyrics($lyrics)
    {
        $this->lyrics = $lyrics;

        return $this;
    }

    /**
     * Gets the value of composer.
     *
     * @return mixed
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * Sets the value of composer.
     *
     * @param mixed $composer the composer
     *
     * @return self
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;

        return $this;
    }

    /**
     * Gets the value of copyright.
     *
     * @return mixed
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Sets the value of copyright.
     *
     * @param mixed $copyright the copyright
     *
     * @return self
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * Gets the value of grouping.
     *
     * @return mixed
     */
    public function getGrouping()
    {
        return $this->grouping;
    }

    /**
     * Sets the value of grouping.
     *
     * @param mixed $grouping the grouping
     *
     * @return self
     */
    public function setGrouping($grouping)
    {
        $this->grouping = $grouping;

        return $this;
    }

    /**
     * Gets the value of artwork.
     *
     * @return mixed
     */
    public function getArtwork()
    {
        return $this->artwork;
    }

    /**
     * Sets the value of artwork.
     *
     * @param mixed $artwork the artwork
     *
     * @return self
     */
    public function setArtwork($artwork)
    {
        $this->artwork = $artwork;

        return $this;
    }

    /**
     * Gets the value of albumArtist.
     *
     * @return mixed
     */
    public function getAlbumArtist()
    {
        return $this->albumArtist;
    }

    /**
     * Sets the value of albumArtist.
     *
     * @param mixed $albumArtist the album artist
     *
     * @return self
     */
    public function setAlbumArtist($albumArtist)
    {
        $this->albumArtist = $albumArtist;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param mixed $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of longdesc.
     *
     * @return mixed
     */
    public function getLongdesc()
    {
        return $this->longdesc;
    }

    /**
     * Sets the value of longdesc.
     *
     * @param mixed $longdesc the longdesc
     *
     * @return self
     */
    public function setLongdesc($longdesc)
    {
        $this->longdesc = $longdesc;

        return $this;
    }

    /**
     * Gets the value of storedesc.
     *
     * @return mixed
     */
    public function getStoredesc()
    {
        return $this->storedesc;
    }

    /**
     * Sets the value of storedesc.
     *
     * @param mixed $storedesc the storedesc
     *
     * @return self
     */
    public function setStoredesc($storedesc)
    {
        $this->storedesc = $storedesc;

        return $this;
    }

    /**
     * Gets the value of TVNetwork.
     *
     * @return mixed
     */
    public function getTVNetwork()
    {
        return $this->TVNetwork;
    }

    /**
     * Sets the value of TVNetwork.
     *
     * @param mixed $TVNetwork the vnetwork
     *
     * @return self
     */
    public function setTVNetwork($TVNetwork)
    {
        $this->TVNetwork = $TVNetwork;

        return $this;
    }

    /**
     * Gets the value of TVShowName.
     *
     * @return mixed
     */
    public function getTVShowName()
    {
        return $this->TVShowName;
    }

    /**
     * Sets the value of TVShowName.
     *
     * @param mixed $TVShowName the vshow name
     *
     * @return self
     */
    public function setTVShowName($TVShowName)
    {
        $this->TVShowName = $TVShowName;

        return $this;
    }

    /**
     * Gets the value of TVEpisode.
     *
     * @return mixed
     */
    public function getTVEpisode()
    {
        return $this->TVEpisode;
    }

    /**
     * Sets the value of TVEpisode.
     *
     * @param mixed $TVEpisode the vepisode
     *
     * @return self
     */
    public function setTVEpisode($TVEpisode)
    {
        $this->TVEpisode = $TVEpisode;

        return $this;
    }

    /**
     * Gets the value of TVSeasonNum.
     *
     * @return mixed
     */
    public function getTVSeasonNum()
    {
        return $this->TVSeasonNum;
    }

    /**
     * Sets the value of TVSeasonNum.
     *
     * @param mixed $TVSeasonNum the vseason num
     *
     * @return self
     */
    public function setTVSeasonNum($TVSeasonNum)
    {
        $this->TVSeasonNum = $TVSeasonNum;

        return $this;
    }

    /**
     * Gets the value of TVEpisodeNum.
     *
     * @return mixed
     */
    public function getTVEpisodeNum()
    {
        return $this->TVEpisodeNum;
    }

    /**
     * Sets the value of TVEpisodeNum.
     *
     * @param mixed $TVEpisodeNum the vepisode num
     *
     * @return self
     */
    public function setTVEpisodeNum($TVEpisodeNum)
    {
        $this->TVEpisodeNum = $TVEpisodeNum;

        return $this;
    }

    /**
     * Gets the value of category.
     *
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the value of category.
     *
     * @param mixed $category the category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Gets the value of keyword.
     *
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Sets the value of keyword.
     *
     * @param mixed $keyword the keyword
     *
     * @return self
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Gets the value of purchaseDate.
     *
     * @return mixed
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Sets the value of purchaseDate.
     *
     * @param mixed $purchaseDate the purchase date
     *
     * @return self
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Gets the value of encodingTool.
     *
     * @return mixed
     */
    public function getEncodingTool()
    {
        return $this->encodingTool;
    }

    /**
     * Sets the value of encodingTool.
     *
     * @param mixed $encodingTool the encoding tool
     *
     * @return self
     */
    public function setEncodingTool($encodingTool)
    {
        $this->encodingTool = $encodingTool;

        return $this;
    }

    /**
     * Gets the value of encodedBy.
     *
     * @return mixed
     */
    public function getEncodedBy()
    {
        return $this->encodedBy;
    }

    /**
     * Sets the value of encodedBy.
     *
     * @param mixed $encodedBy the encoded by
     *
     * @return self
     */
    public function setEncodedBy($encodedBy)
    {
        $this->encodedBy = $encodedBy;

        return $this;
    }

    /**
     * Gets the value of apID.
     *
     * @return mixed
     */
    public function getApID()
    {
        return $this->apID;
    }

    /**
     * Sets the value of apID.
     *
     * @param mixed $apID the ap
     *
     * @return self
     */
    public function setApID($apID)
    {
        $this->apID = $apID;

        return $this;
    }

    /**
     * Gets the value of xID.
     *
     * @return mixed
     */
    public function getXID()
    {
        return $this->xID;
    }

    /**
     * Sets the value of xID.
     *
     * @param mixed $xID the x
     *
     * @return self
     */
    public function setXID($xID)
    {
        $this->xID = $xID;

        return $this;
    }
}