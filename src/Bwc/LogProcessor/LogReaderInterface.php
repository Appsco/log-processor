<?php

namespace Bwc\LogProcessor;

/**
 * Reads log entries
 */
interface LogReaderInterface
{
    /**
     * Reads next line from log resource on each consecutive call. When
     * it reaches the end, returns false.
     *
     * @return string|false
     */
    public function read();
} 