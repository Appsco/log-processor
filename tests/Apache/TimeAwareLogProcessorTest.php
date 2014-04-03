<?php

class TimeAwareLogProcessorTest extends \PHPUnit_Framework_TestCase
{
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
    }

    public function testProcessPasses()
    {
        $logProcessor = new \Bwc\LogProcessor\Apache\TimeAwareLogProcessor(
            $this->logReaderMock,
            $this->logParserMock,
            (new DateTime())->sub(new DateInterval('P1D')),
            (new DateTime())->add(new DateInterval('P1D'))
        );

        $this->logReaderMock->expects($this->once())->method('read')
            ->will($this->returnValue('asdsda'));

        $this->logParserMock->expects($this->once())->method('parse')
            ->will($this->returnValue($entry = new \Bwc\LogProcessor\Apache\CommonLogEntry()));
        $entry->time = (new DateTime())->getTimestamp();

        $result = $logProcessor->process();

        $this->assertEquals($entry, $result);
    }

    public function testProcessDoesntPass()
    {
        $logProcessor = new \Bwc\LogProcessor\Apache\TimeAwareLogProcessor(
            $this->logReaderMock,
            $this->logParserMock,
            (new DateTime())->sub(new DateInterval('P1D')),
            (new DateTime())->sub(new DateInterval('P1D'))
        );

        $this->logReaderMock->expects($this->at(0))->method('read')
            ->will($this->returnValue('asdsda'));

        $this->logReaderMock->expects($this->at(1))->method('read')->will($this->returnValue(null));

        $this->logParserMock->expects($this->once())->method('parse')
            ->will($this->returnValue($entry = new \Bwc\LogProcessor\Apache\CommonLogEntry()));
        $entry->time = (new DateTime())->add(new DateInterval('P2D'))->getTimestamp();

        $result = $logProcessor->process();

        $this->assertNull($result);
    }

    /**
     * @dataProvider processStartTimeFilterOnlyDataProvider
     */
    public function testProcessStartTimeFilterOnly($startTime, $shouldPass)
    {
        $logProcessor = new \Bwc\LogProcessor\Apache\TimeAwareLogProcessor(
            $this->logReaderMock,
            $this->logParserMock,
            $startTime
        );

        $this->logReaderMock->expects($this->at(0))->method('read')
            ->will($this->returnValue('asdsda'));

        if (!$shouldPass) {
            $this->logReaderMock->expects($this->at(1))->method('read')->will($this->returnValue(null));
        }

        $this->logParserMock->expects($this->once())->method('parse')
            ->will($this->returnValue($entry = new \Bwc\LogProcessor\Apache\CommonLogEntry()));
        $entry->time = (new DateTime())->add(new DateInterval('P48D'))->getTimestamp();

        $result = $logProcessor->process();

        if ($shouldPass) {
            $this->assertEquals($entry, $result);
        } else {
            $this->assertNull($result);
        }
    }

    public function processStartTimeFilterOnlyDataProvider()
    {
        return [
            [new DateTime(), true],
            [(new DateTime())->add(new DateInterval('P48DT5S')), false],
        ];
    }
} 