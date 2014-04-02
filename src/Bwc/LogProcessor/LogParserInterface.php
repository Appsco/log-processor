<?php

namespace Bwc\LogProcessor;

interface LogParserInterface
{
    public function parse($line);
}