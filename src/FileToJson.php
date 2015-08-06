<?php
  namespace ActiveCollab\FileToJson;

  use RuntimeException, InvalidArgumentException;

  /**
   * @package ActiveCollab\FileToJson
   */
  class FileToJson
  {
    /**
     * Return file instance for the given file. File type is auto-detected unless forced using $force_type
     *
     * @param  string                             $path
     * @param  string|null                        $mime_type
     * @param  string|null                        $file_name
     * @param  string|null                        $force_type
     * @return \ActiveCollab\FileToJson\File\File
     * @throws InvalidArgumentException
     */
    public function getFile($path, $mime_type = null, $file_name = null, $force_type = null)
    {
      if (!is_file($path)) {
        throw new InvalidArgumentException("File not found '$path'");
      }

      if (empty($file_name)) {
        $file_name = basename($path);
      }

      $file_type = $this->getFileType($mime_type, $file_name, $force_type);

      if ($file_type) {
        return new $file_type($path);
      } else {
        throw new RuntimeException('Failed to detect file type for file ' . $path);
      }
    }

    /**
     * @var array
     */
    private $mime_type_to_type = [
      'text/plain' => 'TextFile'
    ];

    /**
     * @var array
     */
    private $extension_to_type = [
      'txt' => 'TextFile',
    ];

    /**
     * Return full class path based on the given parameters
     *
     * @param  string|null              $mime_type
     * @param  string|null              $file_name
     * @param  string|null              $force_type
     * @return string
     * @throws InvalidArgumentException
     */
    private function getFileType($mime_type, $file_name, $force_type)
    {
      if ($force_type) {
        if (class_exists("ActiveCollab\\FileToJson\\File\\$force_type", true)) {
          return "ActiveCollab\\FileToJson\\File\\$force_type";
        } else {
          throw new InvalidArgumentException("Can't find file type $force_type");
        }
      } else {
        if ($mime_type) {
          if (isset($this->mime_type_to_type[strtolower($mime_type)])) {
            return "ActiveCollab\\FileToJson\\File\\" . $this->mime_type_to_type[strtolower($mime_type)];
          } else {
            throw new InvalidArgumentException("Unsupported MIME type $mime_type");
          }
        } else {
          $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

          if (isset($this->extension_to_type[$extension])) {
            return "ActiveCollab\\FileToJson\\File\\" . $this->extension_to_type[$extension];
          } else {
            throw new InvalidArgumentException("Failed to detect file type from file name $file_name");
          }
        }
      }
    }
  }