<?php

namespace Bwc\LogProcessor;

/**
 * Reads multiple log files
 */
class MultiLogFileReader implements LogReaderInterface
{
    /**
     * @var array
     */
    private $files;

    /**
     * @var SingleLogFileReader
     */
    private $currentReader;

    /**
     * @var int
     */
    private $currentResourceIndex;

    /**
     * @param array $files
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $files)
    {
        if (0 === count($files)) {
            throw new \InvalidArgumentException("Resources can't be an empty array");
        }

        $this->files = $files;
        $this->currentReader = new SingleLogFileReader($files[0]);
        $this->currentResourceIndex = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        $line = $this->currentReader->read();

        if (false === $line) {
            $this->currentReader = $this->fetchNextReader();

            if (null === $this->currentReader) {
                return false;
            } else {
                return $this->read();
            }
        }

        return $line;
    }

    /**
     * @return SingleLogFileReader|null
     */
    private function fetchNextReader()
    {
        if (isset($this->files[++$this->currentResourceIndex])) {
            return new SingleLogFileReader($this->files[$this->currentResourceIndex]);
        } else {
            return null;
        }
    }
} 