<?php

namespace Bwc\LogProcessor\Apache;

use Bwc\LogProcessor\LogParserInterface;
use Bwc\LogProcessor\LogProcessor;
use Bwc\LogProcessor\LogReaderInterface;

class TimeAwareLogProcessor extends LogProcessor
{
    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    public function __construct(LogReaderInterface $reader, LogParserInterface $parser, \DateTime $startTime = null, \DateTime $endTime = null)
    {
        parent::__construct($reader, $parser);
        $this->startDate = $startTime;
        $this->endDate = $endTime;
    }

    protected function passes(CommonLogEntry $entry)
    {
        $entryTime = new \DateTime($entry->time);

        if (null !== $this->startDate && $entryTime < $this->startDate) {
            return false;
        }
        if (null !== $this->endDate && $entryTime > $this->endDate) {
            return false;
        }

        return true;
    }
} 