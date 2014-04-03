<?php

namespace Bwc\LogProcessor;

/**
 * Processes log entries
 */
interface LogProcessorInterface
{
    /**
     * Fetches next line upon each call and returns it in parsed representation
     *
     * @return mixed|null
     */
    public function process();
} 