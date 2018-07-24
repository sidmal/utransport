<?php

namespace UTransport\Test;

use PHPUnit\Framework\TestCase;
use UTransport\Transport\BasicAuth;

/**
 * Class BasicAuthTest
 * @package UTransport\Test
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class BasicAuthTest extends TestCase
{
    public function testInstanceCreateWithoutInitData()
    {
        $basicAuth = new BasicAuth();

        $this->assertNull($basicAuth->getUsername());
        $this->assertNull($basicAuth->getPassword());
        $this->assertFalse($basicAuth->hasBasicAuth());
    }

    public function testInstanceCreateWithInitData()
    {
        $username = 'phpunit';
        $password = 'password';

        $basicAuth = new BasicAuth($username, $password);

        $this->assertEquals($username, $basicAuth->getUsername());
        $this->assertEquals($password, $basicAuth->getPassword());
        $this->assertTrue($basicAuth->hasBasicAuth());
    }
}