<?php

namespace Bwc\LogProcessor;

class LogProcessor implements LogProcessorInterface
{
    /**
     * @var LogReaderInterface
     */
    private $reader;

    /**
     * @var LogParserInterface
     */
    private $parser;

    public function __construct(LogReaderInterface $reader, LogParserInterface $parser)
    {
        $this->reader = $reader;
        $this->parser = $parser;
    }

    /**
     * {@inheritDoc}
     */
    final public function process()
    {
        while ($line = $this->reader->read()) {
            $entry = $this->parser->parse($line);

            // Checks whether entry should be filtered out. Override ::passes() method to filter out entries
            if (true === $this->passes($entry)) {
                return $entry;
            }
        }

        return null;
    }

    /**
     * If method does not return true, this entry will be skipped.
     *
     * @param $entry
     *
     * @return bool
     */
    protected function passes($entry)
    {
        return true;
    }
} 