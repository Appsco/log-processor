<?php

namespace Bwc\LogProcessor\Apache;

/**
 * Common Apache Log entry. Comments on each field show which symbol from Apache LogFormat should be assigned
 * to it
 */
class CommonLogEntry
{
    // %t
    public $time;

    // %a
    public $clientIp;

    // %A
    public $localIp;

    // %B or %b
    public $responseSize;

    // %f
    public $filename;

    // %h
    public $remoteHostname;

    // %H
    public $requestProtocol;

    // %k
    public $keepAliveRequestsNum;

    // %l
    public $remoteLogname;

    // %L
    public $requestLogId;

    // %m
    public $requestMethod;

    // %p
    public $port;

    // %P
    public $processId;

    // %q
    public $queryString;

    // %r
    public $firstLineOfRequest;

    // %R
    public $responseHandler;

    // %D or %T
    public $servingTime;

    // %s
    public $requestStatus;

    // %u
    public $remoteUser;

    // %U
    public $url;

    // %v or %V
    public $serverName;

    // %X
    public $connectionStatus;

    // %I
    public $bytesReceived;

    // %O
    public $bytesSent;

    // %S
    public $bytesTransferred;
} 