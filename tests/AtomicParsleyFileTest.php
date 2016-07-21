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
        $this->assertTrue(file_exists(AtomicParsleyFile::filepath . $file->getFilename()));
    }

    /** @test */
    public function a_new_file_can_be_long()
    {
        $file = new AtomicParsleyFile(false);

        $this->assertTrue($file->save());
        $this->assertTrue(file_exists(AtomicParsleyFile::filepath . $file->getFilename()));
        $this->assertEquals(20917942, filesize(AtomicParsleyFile::filepath . $file->getFilename()));
    }

    /**
     * Deletes the directory with the testing files after all tests passed.
     * Code snipped by @alcuadrado on http://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it#3349792
     */
    public static function tearDownAfterClass()
    {
        $dirPath = AtomicParsleyFile::filepath;
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
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
