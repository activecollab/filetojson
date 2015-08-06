<?php
  namespace ActiveCollab\FileToJson\Test;

  use ActiveCollab\FileToJson\FileToJson;

  /**
   * @package ActiveCollab\FileToJson\Test
   */
  class FileToJsonTest extends TestCase
  {
    /**
     * Test autoloader
     */
    public function testFileToJsonExists()
    {
      $file_to_json = new FileToJson();
      $this->assertInstanceOf('ActiveCollab\FileToJson\FileToJson', $file_to_json);
    }
  }