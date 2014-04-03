<?php

namespace Bwc\LogProcessor;

use Bwc\LogProcessor\Exception\UnparsableLineException;

/**
 * Parses log line by splitting it according to delimiter
 */
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

    /**
     * @param string $delimiter Mark which will be used to separate log line in pieces.
     *                          Eg. for line "value1;value2;value3" delimiter should be ';'
     *                              for "value1 - value2 - value3" delimiter should be ' - ';
     * @param array $entryProperties Properties that extracted parts should be assigned to.
     *                               Eg. $line = "somedomain.com - 538923 - 3000"
     *                                   $entryProperties = ['domain', 'responseBytes', 'responseTime']
     *
     *                                   $entry = $parser->parse($line);
     *                                   $entry->domain will be "somedomain.com"
     *                                   $entry->responseBytes will be 538923 etc.
     * @param string $logEntryClassName Log entry data object class name
     */
    public function __construct($delimiter, $entryProperties, $logEntryClassName = '\stdClass')
    {
        $this->delimiter = $delimiter;
        $this->entryProperties = $entryProperties;
        $this->logEntryClassName = $logEntryClassName;
    }

    /**
     * {@inheritDoc}
     */
    public function parse($line)
    {
        // Create entry class
        $entry = new $this->logEntryClassName();

        // Split line by delimiter
        $separated = explode($this->delimiter, $line);
        $numProperties = count($this->entryProperties);

        // Check whether number of properties and number of extracted parts match. If they don't, there is something
        // wrong.
        if (count($separated) !== $numProperties) {
            throw new UnparsableLineException(sprintf(
                "Extracted %d parts from string, but expected to find %d.
                Check your delimiter and entry properties.",
                count($separated),
                $numProperties
            ));
        }

        // Assign each extracted part to it's property in entry
        for ($i = 0; $i < $numProperties; $i++) {
            $property = $this->entryProperties[$i];
            $entry->$property = $separated[$i];
        }

        return $entry;
    }
} 