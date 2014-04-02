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

    final public function process()
    {
        if ($line = $this->reader->read()) {
            $entry = $this->parser->parse($line);

            if (true === $this->passes($entry)) {
                return $entry;
            } else {
                return $this->process();
            }
        } else {
            return null;
        }
    }

    /**
     * If method does not true, this entry will be skipped.
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