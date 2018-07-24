<?php

namespace UTransport\Transport;

/**
 * Class Request
 * @package UTransport\Transport
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class Request
{
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $data;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var BasicAuth
     */
    private $basicAuth;

    /**
     * Request constructor.
     *
     * @param string $url
     * @param string $method
     * @param string $data
     * @param array $headers
     * @param BasicAuth $basicAuth
     */
    public function __construct(
        string $url = '',
        string $method = self::METHOD_GET,
        string $data = '',
        array $headers = [],
        BasicAuth $basicAuth = null
    )
    {
        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
        $this->headers = $headers;

        if (null === $basicAuth) {
            $basicAuth = new BasicAuth();
        }

        $this->basicAuth = $basicAuth;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Request
     */
    public function setUrl(string $url): Request
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return Request
     */
    public function setData(string $data): Request
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return Request
     */
    public function setHeaders(array $headers): Request
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return BasicAuth
     */
    public function getBasicAuth(): BasicAuth
    {
        return $this->basicAuth;
    }

    /**
     * @param BasicAuth $basicAuth
     * @return Request
     */
    public function setBasicAuth(BasicAuth $basicAuth): Request
    {
        $this->basicAuth = $basicAuth;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function setMethod(string $method): Request
    {
        $this->method = $method;
        return $this;
    }
}