<?php

namespace Bwc\LogProcessor;

class SingleLogFileReader implements LogReaderInterface
{
    /**
     * @var string
     */
    private $fileHandle;

    public function __construct($filePath)
    {
        $this->fileHandle = fopen($filePath, 'r');
    }

    public function read()
    {
        $line = fgets($this->fileHandle);

        return $line;
    }
} 