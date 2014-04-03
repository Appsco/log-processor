<?php

namespace Bwc\LogProcessor\Apache;

use Bwc\LogProcessor\LogParserInterface;
use Bwc\LogProcessor\LogProcessor;
use Bwc\LogProcessor\LogReaderInterface;

class TimeAwareLogProcessor extends LogProcessor
{
    /**
     * @var int|null
     */
    private $startTime;

    /**
     * @var int|null
     */
    private $endTime;

    public function __construct(LogReaderInterface $reader, LogParserInterface $parser, \DateTime $startTime = null, \DateTime $endTime = null)
    {
        parent::__construct($reader, $parser);

        if ($startTime) {
            $this->startTime = $startTime->getTimestamp();
        }
        if ($endTime) {
            $this->endTime = $endTime->getTimestamp();
        }
    }

    /**
     * Checks whether entry time is within given time limits.
     *
     * @param CommonLogEntry $entry
     *
     * @return bool
     */
    protected function passes($entry)
    {
        if (null !== $this->startTime && $entry->time < $this->startTime) {
            return false;
        }
        if (null !== $this->endTime && $entry->time > $this->endTime) {
            return false;
        }

        return true;
    }
} 