<?php

namespace UTransport\Test;

use PHPUnit\Framework\TestCase;
use UTransport\Transport\Response;

/**
 * Class ResponseTest
 * @package UTransport\Test
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class ResponseTest extends TestCase
{
    public function testInstanceCreateWithoutInitData()
    {
        $response = new Response();

        $this->assertEquals(Response::HTTP_OK, $response->getHttpCode());
        $this->assertEmpty($response->getBody());
        $this->assertEmpty($response->getJsonBody());
    }

    public function testInstanceCreateWithInitData()
    {
        $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $body = 'some response body';

        $response = new Response($httpCode, $body);

        $this->assertEquals($httpCode, $response->getHttpCode());
        $this->assertEquals($body, $response->getBody());
        $this->assertEmpty($response->getJsonBody());
    }

    public function testIsSuccessfullyResponseFlag()
    {
        $this->assertTrue((new Response(Response::HTTP_OK))->isSuccessfully());

    }

    public function testGetJsonBody()
    {
        $response = (new Response())
            ->setBody('{"param1": "a", "param2": 1, "param3": 0.01, "param4": false}')
            ->getJsonBody();

        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('param1', $response);
        $this->assertEquals('a', $response['param1']);
        $this->assertArrayHasKey('param2', $response);
        $this->assertEquals(1, $response['param2']);
        $this->assertArrayHasKey('param3', $response);
        $this->assertEquals(0.01, $response['param3']);
        $this->assertArrayHasKey('param4', $response);
        $this->assertFalse($response['param4']);
    }
}