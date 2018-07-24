<?php

namespace UTransport\Test;

use PHPUnit\Framework\TestCase;
use UTransport\Transport\BasicAuth;
use UTransport\Transport\Request;
use UTransport\Transport\RequestLog;
use UTransport\Transport\Response;
use UTransport\Transport\Transport;

/**
 * Class TransportTest
 * @package UTransport\Test
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class TransportTest extends TestCase
{
    public function testGetMethod()
    {
        $request = (new Request())
            ->setUrl('http://www.someurl.com')
            ->setData('param1=1&param2=2&param3=3')
            ->setBasicAuth(new BasicAuth('username', 'password'));

        $mock = $this->getMockBuilder(Transport::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('get');

        /** @var Transport $mock */
        $response = $mock->{$request->getMethod()}($request);
        $log = $mock->getLog();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(RequestLog::class, $log);
    }

    public function testPostMethod()
    {
        $request = (new Request())
            ->setUrl('http://www.someurl.com')
            ->setMethod(Request::METHOD_POST)
            ->setData('param1=1&param2=2&param3=3')
            ->setBasicAuth(new BasicAuth('username', 'password'));

        $mock = $this->getMockBuilder(Transport::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('post');

        /** @var Transport $mock */
        $response = $mock->{$request->getMethod()}($request);
        $log = $mock->getLog();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(RequestLog::class, $log);
    }

    public function testGetLog()
    {
        $request = (new Request())
            ->setUrl('http://www.mocky.io/v2/5b573cb731000002334d21ce')
            ->setMethod(Request::METHOD_POST)
            ->setBasicAuth(new BasicAuth('username', 'password'));

        $transport = new Transport(1);

        /** @var Response $response */
        $response = $transport->{$request->getMethod()}($request);
        $log = $transport->getLog();

        $this->assertFalse($response->isSuccessfully());
        $this->assertArrayHasKey('message', $response->getJsonBody());

        $this->assertEquals(Response::HTTP_NOT_FOUND, $log->getResponseHttpCode());
        $this->assertEquals($request->getMethod(), $log->getMethod());
        $this->assertRegExp('|Authorization:\ Basic\ \S+|', $log->getRequestHeaders());
    }
}