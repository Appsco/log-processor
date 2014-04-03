<?php

namespace Bwc\LogProcessor;

use Bwc\LogProcessor\Exception\UnparsableLineException;

/**
 * Parses a log line
 */
interface LogParserInterface
{
    /**
     * Parses a line from log
     *
     * @param string $line
     *
     * @return mixed
     *
     * @throws UnparsableLineException When line can't be parsed
     */
    public function parse($line);
}