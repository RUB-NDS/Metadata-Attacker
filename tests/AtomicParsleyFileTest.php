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
    public function the_metadata_attacker_can_set_some_data_to_the_video_file()
    {
        $file = new AtomicParsleyFile();
        $file->setAlbum("Tolles Album");
        $file->save();


        $loadedFile = new AtomicParsleyFile($file->getFullFilepath());
        $this->assertEquals("Tolles Album", $loadedFile->getAlbum());
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
