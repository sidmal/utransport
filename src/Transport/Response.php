<?php

namespace UTransport\Transport;

/**
 * Class Response
 * @copyright Copyright (с) 2018.
 * @package UTransport
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class Response
{
    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * @var int
     */
    private $httpCode;

    /**
     * @var string
     */
    private $body;

    /**
     * Response constructor.
     *
     * @param int $httpCode
     * @param string $body
     */
    public function __construct(
        int $httpCode = self::HTTP_OK,
        string $body = ''
    )
    {
        $this->httpCode = $httpCode;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     * @return Response
     */
    public function setHttpCode(int $httpCode): Response
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Response
     */
    public function setBody(string $body): Response
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccessfully(): bool
    {
        return $this->httpCode == self::HTTP_OK;
    }

    /**
     * @return array
     */
    public function getJsonBody()
    {
        if ('' === $this->body) {
            return [];
        }

        $body = json_decode($this->body, true);

        if (null === $body) {
            return [];
        }

        return $body;
    }
}