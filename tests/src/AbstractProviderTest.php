<?php

namespace UTransport\Test;

use PHPUnit\Framework\TestCase;
use UTransport\AbstractProvider;
use UTransport\Transport\BasicAuth;
use UTransport\Transport\Request;
use UTransport\Transport\RequestLog;
use UTransport\Transport\Response;
use UTransport\Transport\Transport;

/**
 * Class AbstractProviderTest
 * @package UTransport\Test
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class AbstractProviderTest extends TestCase
{
    public function testTransport()
    {
        $this->assertInstanceOf(Transport::class, (new AbstractProvider())->getTransport());
    }

    public function testCacheKey()
    {
        $request = (new Request())
            ->setUrl('http://www.someurl.com')
            ->setData('param1=1&param2=2&param3=3');

        try {
            $method = new \ReflectionMethod(AbstractProvider::class, 'getCacheKey');
            $method->setAccessible(true);

            $cacheKey = $method->invoke(new AbstractProvider(), $request);

            $this->assertRegExp('|^[a-f0-9]{32}$|i', $cacheKey);
            $this->assertEquals(md5($request->getUrl().$request->getData()), $cacheKey);
        } catch (\ReflectionException $e) {
            $this->assertTrue(false);
        }
    }

    public function testReturnInstances()
    {
        $request = (new Request())
            ->setUrl('http://www.someurl.com')
            ->setData('param1=1&param2=2&param3=3');

        $mock = $this->getMockBuilder(AbstractProvider::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('doRequest');

        $mock->expects($this->once())
            ->method('getTransport')
            ->willReturn(new Transport());

        /** @var AbstractProvider $mock */
        $response = $mock->doRequest($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(RequestLog::class, $mock->getTransport()->getLog());
    }

    public function testTrueRequest()
    {
        $url = 'http://www.mocky.io/v2/5b573cb731000002334d21ce';

        $request = (new Request())
            ->setUrl($url)
            ->setMethod(Request::METHOD_POST)
            ->setBasicAuth(new BasicAuth('username', 'password'));

        $provider = new AbstractProvider();
        $response = $provider->doRequest($request);
        $log = $provider->getTransport()->getLog();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertFalse($response->isSuccessfully());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getHttpCode());
        $this->assertArrayHasKey('message', $response->getJsonBody());

        $this->assertEquals($url, $log->getUrl());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $log->getResponseHttpCode());
        $this->assertEquals($request->getMethod(), $log->getMethod());
        $this->assertRegExp('|Authorization:\ Basic\ \S+|', $log->getRequestHeaders());
    }
}