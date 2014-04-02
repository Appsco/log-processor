<?php

namespace Bwc\LogProcessor;

use Bwc\LogProcessor\Exception\UnparsableLineException;

class SplitStringLogParser implements LogParserInterface
{
    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string[]
     */
    private $entryProperties;

    /**
     * @var string
     */
    private $logEntryClassName;

    public function __construct($delimiter, $entryProperties, $logEntryClassName = '\stdClass')
    {
        $this->delimiter = $delimiter;
        $this->entryProperties = $entryProperties;
        $this->logEntryClassName = $logEntryClassName;
    }

    public function parse($line)
    {
        $entry = new $this->logEntryClassName();
        $separated = explode($this->delimiter, $line);
        $numProperties = count($this->entryProperties);

        if (count($separated) !== $numProperties) {
            throw new UnparsableLineException(sprintf(
                "Extracted %d parts from string, but expected to find %d.
                Check your delimiter and entry properties.",
                count($separated),
                $numProperties
            ));
        }

        for ($i = 0; $i < $numProperties; $i++) {
            $property = $this->entryProperties[$i];
            $entry->$property = $separated[$i];
        }

        return $entry;
    }
} 