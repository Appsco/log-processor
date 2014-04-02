<?php

class SplitStringLogParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider parseDataProvider
     */
    public function testValidParse($delimiter, $properties, $className)
    {
        $parser = new \Bwc\LogProcessor\SplitStringLogParser($delimiter, $properties, $className);

        $values = array_map(function ($property) { return "{$property}Val"; }, $properties);
        $line = join($delimiter, $values);

        $entry = $parser->parse($line);

        $this->assertInstanceOf($className, $entry);

        foreach ($properties as $property) {
            $this->assertEquals("{$property}Val", $entry->$property);
        }
    }

    public function parseDataProvider()
    {
        return [
            [' ', ['one', 'two', 'three'], '\stdClass'],
            ['- ', ['blah', 'blah'], '\stdClass'],
            ['.', ['only_one'], '\stdClass'],
        ];
    }

    public function testInvalidParse()
    {
        $this->setExpectedException('Bwc\LogProcessor\Exception\UnparsableLineException');

        $parser = new \Bwc\LogProcessor\SplitStringLogParser('-', [1, 2, 3]);

        $parser->parse('one-two');
    }
} 