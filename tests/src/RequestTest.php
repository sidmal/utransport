<?php

namespace UTransport\Test;

use PHPUnit\Framework\TestCase;
use UTransport\Transport\BasicAuth;
use UTransport\Transport\Request;

/**
 * Class RequestTest
 * @package UTransport\Test
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class RequestTest extends TestCase
{
    public function testInstanceCreateWithoutInitData()
    {
        $request = new Request();

        $this->assertEmpty($request->getUrl());
        $this->assertEquals(Request::METHOD_GET, $request->getMethod());
        $this->assertEmpty($request->getData());
        $this->assertEmpty($request->getHeaders());

        $this->assertInstanceOf(BasicAuth::class, $request->getBasicAuth());

        $this->assertEmpty($request->getBasicAuth()->getUsername());
        $this->assertEmpty($request->getBasicAuth()->getPassword());
        $this->assertFalse($request->getBasicAuth()->hasBasicAuth());
    }

    public function testInstanceCreateWithInitData()
    {
        $url = 'http://www.someurl.com';
        $method = Request::METHOD_POST;
        $data = json_encode(['param1' => 'a', 'param2' => 'b']);
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json'
        ];

        $baUsername = 'phpunit';
        $baPassword = 'password';

        $basicAuth = new BasicAuth($baUsername, $baPassword);

        $request = new Request($url, $method, $data, $headers, $basicAuth);

        $this->assertEquals($url, $request->getUrl());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($data, $request->getData());
        $this->assertEquals($headers, $request->getHeaders());

        $this->assertInstanceOf(BasicAuth::class, $request->getBasicAuth());

        $this->assertEquals($baUsername, $request->getBasicAuth()->getUsername());
        $this->assertEquals($baPassword, $request->getBasicAuth()->getPassword());
        $this->assertTrue($request->getBasicAuth()->hasBasicAuth());
    }
}