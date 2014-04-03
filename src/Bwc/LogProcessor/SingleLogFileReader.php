<?php

namespace Bwc\LogProcessor;

/**
 * Reads a single log file
 */
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

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        $line = fgets($this->fileHandle);

        return $line;
    }

    public function __destruct()
    {
        fclose($this->fileHandle);
    }
} 