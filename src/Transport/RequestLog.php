<?php

namespace UTransport\Transport;

/**
 * Class RequestLog
 * @package UTransport
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class RequestLog
{
    /**
     * @var string
     */
    private $data;

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
    private $requestHeaders;

    /**
     * @var int
     */
    private $responseHttpCode;

    /**
     * @var string
     */
    private $responseHeaders;

    /**
     * @var string
     */
    private $response;

    /**
     * @var float
     */
    private $time;

    /**
     * RequestLog constructor.
     * @param string $url
     * @param string $method
     * @param string $data
     * @param string $requestHeaders
     * @param int $responseHttpCode
     * @param string $responseHeaders
     * @param string $response
     * @param float $time
     */
    public function __construct(
        string $url = '',
        string $method = Request::METHOD_GET,
        string $data = '',
        string $requestHeaders = '',
        int $responseHttpCode = Response::HTTP_OK,
        string $responseHeaders = '',
        string $response = '',
        float $time = 0.00
    )
    {
        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
        $this->requestHeaders = $requestHeaders;
        $this->responseHttpCode = $responseHttpCode;
        $this->responseHeaders = $responseHeaders;
        $this->response = $response;
        $this->time = $time;
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
     * @return RequestLog
     */
    public function setData(string $data): RequestLog
    {
        $this->data = $data;
        return $this;
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
     * @return RequestLog
     */
    public function setUrl(string $url): RequestLog
    {
        $this->url = $url;
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
     * @return RequestLog
     */
    public function setMethod(string $method): RequestLog
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestHeaders(): string
    {
        return $this->requestHeaders;
    }

    /**
     * @param string $requestHeaders
     * @return RequestLog
     */
    public function setRequestHeaders(string $requestHeaders): RequestLog
    {
        $this->requestHeaders = $requestHeaders;
        return $this;
    }

    /**
     * @return int
     */
    public function getResponseHttpCode(): int
    {
        return $this->responseHttpCode;
    }

    /**
     * @param int $responseHttpCode
     * @return RequestLog
     */
    public function setResponseHttpCode(int $responseHttpCode): RequestLog
    {
        $this->responseHttpCode = $responseHttpCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseHeaders(): string
    {
        return $this->responseHeaders;
    }

    /**
     * @param string $responseHeaders
     * @return RequestLog
     */
    public function setResponseHeaders(string $responseHeaders): RequestLog
    {
        $this->responseHeaders = $responseHeaders;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $response
     * @return RequestLog
     */
    public function setResponse(string $response): RequestLog
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return float
     */
    public function getTime(): float
    {
        return $this->time;
    }

    /**
     * @param float $time
     * @return RequestLog
     */
    public function setTime(float $time): RequestLog
    {
        $this->time = $time;
        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}