<?php

class LogProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Bwc\LogProcessor\LogProcessor
     */
    private $logProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $logReaderMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $logParserMock;

    protected function setUp()
    {
        $this->logReaderMock = $this->getMock('Bwc\LogProcessor\LogReaderInterface');
        $this->logParserMock = $this->getMock('Bwc\LogProcessor\LogParserInterface');

        $this->logProcessor = new \Bwc\LogProcessor\LogProcessor($this->logReaderMock, $this->logParserMock);
    }

    public function testProcess()
    {
        $this->logReaderMock->expects($this->once())->method('read')
            ->will($this->returnValue($readerReturn = 'first second third'));

        $this->logParserMock->expects($this->once())->method('parse')
            ->with($readerReturn)
            ->will($this->returnValue($entry = new \stdClass()));

        $result = $this->logProcessor->process();

        $this->assertSame($entry, $result);
    }

    public function testProcessNull()
    {
        $this->logReaderMock->expects($this->once())->method('read')
            ->will($this->returnValue($readerReturn = null));

        $this->logParserMock->expects($this->never())->method('parse');

        $result = $this->logProcessor->process();

        $this->assertNull($result);
    }
}