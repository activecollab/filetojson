<?php
  namespace ActiveCollab\FileToJson\Test;

  use ActiveCollab\FileToJson\FileToJson;

  /**
   * @package ActiveCollab\FileToJson\Test
   */
  class FileToJsonTest extends TestCase
  {
    /**
     * @var FileToJson
     */
    private $file_to_json;

    /**
     * Set up test environment
     */
    public function setUp()
    {
      parent::setUp();

      $this->file_to_json = new FileToJson();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetFileThrowsAnExceptionOnUnexistingPath()
    {
      $this->assertInstanceOf('\ActiveCollab\FileToJson\File\File', $this->file_to_json->getFile('this one does not exist for sure.txt'));
    }

    /**
     * Test if file to JSON factory produces a file instance
     */
    public function testFactoryProducesFile()
    {
      $this->assertInstanceOf('\ActiveCollab\FileToJson\File\File', $this->file_to_json->getFile(__FILE__, null, null, 'TextFile'));
    }

    public function testAutodetectTypeByMimeType()
    {
      $this->assertInstanceOf('\ActiveCollab\FileToJson\File\TextFile', $this->file_to_json->getFile(__FILE__, 'text/plain'));
    }

    public function testAutodetectTypeByFileName()
    {
      $this->assertInstanceOf('\ActiveCollab\FileToJson\File\TextFile', $this->file_to_json->getFile(__FILE__, null, 'samsung.txt'));
    }

    public function testAutodetectIgnoresCase()
    {
      $this->assertInstanceOf('\ActiveCollab\FileToJson\File\TextFile', $this->file_to_json->getFile(__FILE__, 'text/PLAIN'));
      $this->assertInstanceOf('\ActiveCollab\FileToJson\File\TextFile', $this->file_to_json->getFile(__FILE__, null, 'samsung.TxT'));
    }
  }