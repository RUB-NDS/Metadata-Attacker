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
        $file->setComment("My very important comment.");
        $file->setYear(2002);
        $file->setLyrics("Hey Hey Hey!");
        $file->setComposer("Lednerb");
        $file->setCopyright("(c) 2016 by Lednerb");
        $file->setAlbumArtist("P-Francis and the Prez");
        $file->setDescription("A very genius video for testing purposes.");
        $file->setLongdesc("Long description comes here.");
        $file->setStoredesc("Lednerbs webshop");
        $file->setTVNetwork("HBO");
        $file->setTVShowName("Game of Thrones");
        $file->setTVEpisode("The King from the North");
        $file->setCategory("Fantasy, Genius");
        $file->setKeyword("GoT, Episode, Nice");
        $file->setPurchaseDate("Today");
        $file->setEncodingTool("My own developed tool.");
        $file->setEncodedBy("Great Encoding Guy");
        $file->setApID("Account name");
        $file->setXID("Vendor supplied iTunes xID");

        $file->save();

        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());

        $this->assertEquals("Great Artist!", $loadedFile->getArtist());
        $this->assertEquals("Very nice title!", $loadedFile->getTitle());
        $this->assertEquals("My hippy-the-hop Album", $loadedFile->getAlbum());
        $this->assertEquals("Heavy Metal, Strange Pop", $loadedFile->getGenre());
        $this->assertEquals("My very important comment.", $loadedFile->getComment());
        $this->assertEquals(2002, $loadedFile->getYear());
        $this->assertEquals("Hey Hey Hey!", $loadedFile->getLyrics());
        $this->assertEquals("Lednerb", $loadedFile->getComposer());
        $this->assertEquals("(c) 2016 by Lednerb", $loadedFile->getCopyright());
        $this->assertEquals("P-Francis and the Prez", $loadedFile->getAlbumArtist());
        $this->assertEquals("A very genius video for testing purposes.", $loadedFile->getDescription());
        $this->assertEquals("Long description comes here.", $loadedFile->getLongdesc());
        $this->assertEquals("Lednerbs webshop", $loadedFile->getStoredesc());
        $this->assertEquals("HBO", $loadedFile->getTVNetwork());
        $this->assertEquals("Game of Thrones", $loadedFile->getTVShowName());
        $this->assertEquals("The King from the North", $loadedFile->getTVEpisode());
        $this->assertEquals("Fantasy, Genius", $loadedFile->getCategory());
        $this->assertEquals("GoT, Episode, Nice", $loadedFile->getKeyword());
        $this->assertEquals("Today", $loadedFile->getPurchaseDate());
        $this->assertEquals("My own developed tool.", $loadedFile->getEncodingTool());
        $this->assertEquals("Great Encoding Guy", $loadedFile->getEncodedBy());
        $this->assertEquals("Account name", $loadedFile->getApID());
        $this->assertEquals("Vendor supplied iTunes xID", $loadedFile->getXID());
    }

    /** @test */
    public function the_user_can_enter_special_char_in_album_field()
    {
        $file = new AtomicParsleyFile();
        $file->setAlbum("Here's a special char.");
        $file->save();

        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());

        $this->assertEquals("Here's a special char.", $loadedFile->getAlbum());
    }

    /** @test */
    public function the_user_can_enter_much_text_in_longdesc_field()
    {
        $content = iconv('UTF-16', 'UTF-16', file_get_contents('/var/www/attacker/web/video/xss.txt'));



        $file = new AtomicParsleyFile();
        $file->setLongdesc($content);
        $file->save();

        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());

        $this->assertEquals($content, iconv('UTF-16', 'UTF-16', $loadedFile->getLongdesc()));
    }

    /** @test */
    public function the_fuzzer_works_correct()
    {
        $this->assertEquals("AAAAA", AtomicParsleyFile::fuzzer(5));
    }

    /** @test */
    public function test_max_length_of_title_field()
    {
         // $length = 130924; // Longdesc
//        $length = 130923; // storedesc

        $file = new AtomicParsleyFile();
        $file->setTitle(AtomicParsleyFile::fuzzer(50));
        $file->save();

        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());

        $this->assertEquals($file->getTitle(), $loadedFile->getTitle());
    }

    /** @test */
    public function function_get_max_length_of_fields_works()
    {
        $this->assertEquals(256, AtomicParsleyFile::getMaxLengthOfField("Artist"));
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
