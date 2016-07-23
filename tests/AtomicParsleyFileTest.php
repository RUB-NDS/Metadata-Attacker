<?php

class AtomicParsleyFileTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function setters_and_getters_are_working()
    {
        $file = new AtomicParsleyFile();
        $file->setAlbum("Mein Album");

        $this->assertEquals("Mein Album", $file->getAlbum());
    }

    /** @test */
    public function a_new_file_can_be_saved_in_tmp_dir()
    {
        $file = new AtomicParsleyFile();

        $this->assertTrue($file->save());
        $this->assertTrue(file_exists($file->getFullFilepath()));
    }

    /** @test */
    public function a_new_file_is_short_via_standard()
    {
        $file = new AtomicParsleyFile();
        $file->save();

        $this->assertGreaterThanOrEqual(1046015, filesize($file->getFullFilepath()));
    }

    /** @test */
    public function a_new_file_can_be_long()
    {
        $file = new AtomicParsleyFile();
        $file->setShort(false);
        $file->save();

        $this->assertGreaterThanOrEqual(20917942, filesize($file->getFullFilepath()));
    }

    /** @test */
    public function the_filename_is_correctly_set_after_loading_a_video_file()
    {
        $file = new AtomicParsleyFile();
        $file->save();

        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());
        $this->assertEquals($file->getFilename(), $loadedFile->getFilename());
    }

    /** @test */
    public function the_metadata_attacker_can_set_all_data_to_the_video_file()
    {
        $file = new AtomicParsleyFile();

        $file->setArtist("Great Artist!");
        $file->setTitle("Very nice title!");
        $file->setAlbum("My hippy-the-hop Album");
        $file->setGenre("Heavy Metal, Strange Pop");
        $file->setTracknum(42);
        $file->setDisk(24);
        $file->setComment("My very important comment.");
        $file->setYear(2002);
        $file->setLyrics("Hey Hey Hey!");
        $file->setComposer("Lednerb");
        $file->setCopyright("(c) 2016 by Lednerb");
        $file->setBpm(50);
        $file->setAlbumArtist("P-Francis and the Prez");
        $file->setCompilation(true);
        $file->setHdvideo(true);
        $file->setAdvisory("clean");
        $file->setStik("Home Video"); // TODO: Values?
        $file->setDescription("A very genius video for testing purposes.");
        $file->setLongdesc("Long description comes here.");
        $file->setStoredesc("Lednerbs webshop");
        $file->setTVNetwork("HBO");
        $file->setTVShowName("Game of Thrones");
        $file->setTVEpisode("The King from the North");
        $file->setTVSeasonNum(3);
        $file->setTVEpisodeNum(7);
        $file->setPodcastFlag(true);
        $file->setCategory("Fantasy, Genius");
        $file->setKeyword("GoT, Episode, Nice");
        $file->setPodcastURL("http://attacker.com");
        $file->setPodcastGUID("http://attacker.org");
        $file->setPurchaseDate("Today");
        $file->setEncodingTool("My own developed tool.");
        $file->setEncodedBy("Great Encoding Guy");
        $file->setApID("Account name");
        $file->setCnID(70);
        $file->setGeID(99);
        $file->setXID("Vendor supplied iTunes xID");
        $file->setGapless(true);
        $file->setContentRating("NC-17");

        $file->save();
        // TODO: Lyrics File
        // TODO: Artwork

        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());

        $this->assertEquals("Great Artist!", $loadedFile->getArtist());
        $this->assertEquals("Very nice title!", $loadedFile->getTitle());
        $this->assertEquals("My hippy-the-hop Album", $loadedFile->getAlbum());
        $this->assertEquals("Heavy Metal, Strange Pop", $loadedFile->getGenre());
        $this->assertEquals(42, $loadedFile->getTracknum());
        $this->assertEquals(24, $loadedFile->getDisk());
        $this->assertEquals("My very important comment.", $loadedFile->getComment());
        $this->assertEquals(2002, $loadedFile->getYear());
        $this->assertEquals("Hey Hey Hey!", $loadedFile->getLyrics());
        $this->assertEquals("Lednerb", $loadedFile->getComposer());
        $this->assertEquals("(c) 2016 by Lednerb", $loadedFile->getCopyright());
        $this->assertEquals("50", $loadedFile->getBpm());
        $this->assertEquals("P-Francis and the Prez", $loadedFile->getAlbumArtist());
        $this->assertEquals(true, $loadedFile->getCompilation());
        $this->assertEquals(true, $loadedFile->getHdvideo());
        $this->assertEquals("Clean Content", $loadedFile->getAdvisory());
        $this->assertEquals("Home Video", $loadedFile->getStik());
        $this->assertEquals("A very genius video for testing purposes.", $loadedFile->getDescription());
        $this->assertEquals("Long description comes here.", $loadedFile->getLongdesc());
        $this->assertEquals("Lednerbs webshop", $loadedFile->getStoredesc());
        $this->assertEquals("HBO", $loadedFile->getTVNetwork());
        $this->assertEquals("Game of Thrones", $loadedFile->getTVShowName());
        $this->assertEquals("The King from the North", $loadedFile->getTVEpisode());
        $this->assertEquals(3, $loadedFile->getTVSeasonNum());
        $this->assertEquals(7, $loadedFile->getTVEpisodeNum());
        $this->assertEquals(true, $loadedFile->getPodcastFlag());
        $this->assertEquals("Fantasy, Genius", $loadedFile->getCategory());
        $this->assertEquals("GoT, Episode, Nice", $loadedFile->getKeyword());
        $this->assertEquals("http://attacker.com", $loadedFile->getPodcastURL());
        $this->assertEquals("http://attacker.org", $loadedFile->getPodcastGUID());
        $this->assertEquals("Today", $loadedFile->getPurchaseDate());
        $this->assertEquals("My own developed tool.", $loadedFile->getEncodingTool());
        $this->assertEquals("Great Encoding Guy", $loadedFile->getEncodedBy());
        $this->assertEquals("Account name", $loadedFile->getApID());
        $this->assertEquals(70, $loadedFile->getCnID());
        $this->assertEquals(99, $loadedFile->getGeID());
        $this->assertEquals("Vendor supplied iTunes xID", $loadedFile->getXID());
        $this->assertEquals(true, $loadedFile->getGapless());
        $this->assertEquals("[com.apple.iTunes;iTunEXTC] contains: mpaa|NC-17|500|", $loadedFile->getContentRating());
    }

    /**
     * Deletes the directory with the testing files after all tests passed.
     * Code snipped by @alcuadrado on http://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it#3349792
     */
    public static function tearDownAfterClass()
    {
        $dirPath = AtomicParsleyFile::filepath;
        if (! is_dir($dirPath)) {
            throw new InvcalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            unlink($file);
        }
        rmdir($dirPath);
    }
}
