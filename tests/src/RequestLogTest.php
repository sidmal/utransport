<?php

namespace UTransport\Test;

use PHPUnit\Framework\TestCase;
use UTransport\Transport\Request;
use UTransport\Transport\RequestLog;
use UTransport\Transport\Response;

/**
 * Class RequestLogTest
 * @package UTransport\Test
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class RequestLogTest extends TestCase
{
    public function testInstanceCreateWithoutInitData()
    {
        $log = new RequestLog();

        $this->assertEmpty($log->getUrl());
        $this->assertEquals(Request::METHOD_GET, $log->getMethod());
        $this->assertEmpty($log->getData());
        $this->assertEmpty($log->getRequestHeaders());
        $this->assertEquals(Response::HTTP_OK, $log->getResponseHttpCode());
        $this->assertEmpty($log->getResponseHeaders());
        $this->assertEmpty($log->getResponse());
        $this->assertEquals(0.00, $log->getTime());
    }

    public function testInstanceCreateWithInitData()
    {
        $url = 'http://www.someurl.com';
        $method = Request::METHOD_POST;
        $data = '{"param1": "a", "param2": "b"}';
        $requestHeaders = 'Host: someurl.com';
        $responseHttpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $responseHeaders = 'HTTP/1.1 200 OK';
        $response = 'some response message';
        $time = 1.001;

        $log = new RequestLog(
            $url,
            $method,
            $data,
            $requestHeaders,
            $responseHttpCode,
            $responseHeaders,
            $response,
            $time
        );

        $this->assertEquals($url, $log->getUrl());
        $this->assertEquals($method, $log->getMethod());
        $this->assertEquals($data, $log->getData());
        $this->assertEquals($requestHeaders, $log->getRequestHeaders());
        $this->assertEquals($responseHttpCode, $log->getResponseHttpCode());
        $this->assertEquals($responseHeaders, $log->getResponseHeaders());
        $this->assertEquals($response, $log->getResponse());
        $this->assertEquals($time, $log->getTime());
    }

    public function testToArray()
    {
        $data = [
            'url' => 'http://www.someurl.com',
            'method' => Request::METHOD_POST,
            'data' => '{"param1": "a", "param2": "b"}',
            'requestHeaders' => 'Host: someurl.com',
            'responseHttpCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'responseHeaders' => 'HTTP/1.1 200 OK',
            'response' => 'some response message',
            'time' => 1.001
        ];

        $log = new RequestLog();

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (false === method_exists($log, $method)) {
                continue;
            }

            $log->{$method}($value);
        }

        $this->assertEquals($data, $log->toArray());
    }
}