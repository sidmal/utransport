<?php

namespace UTransport\Transport;

use Psr\Log\LoggerInterface;

/**
 * Class Transport
 * @package UTransport
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class Transport
{
    const FIELD_INFO_HTTP_RESPONSE_CODE = 'http_code';
    const FIELD_INFO_HTTP_REQUEST_HEADERS = 'request_header';

    const LOGGER_MESSAGE = 'Request log';

    /**
     * @var RequestLog
     */
    private $log;

    /**
     * @var resource
     */
    private $client;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * Transport constructor.
     *
     * @param int $cTimeout
     */
    public function __construct(int $cTimeout = 3)
    {
        $this->client = curl_init();

        curl_setopt($this->client, CURLOPT_TIMEOUT, $cTimeout);
        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->client, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->client, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->client, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->client, CURLOPT_HEADER, true);

        $this->log = new RequestLog();
    }

    /**
     * @param LoggerInterface $logger
     * @return Transport
     */
    public function setLogger(LoggerInterface $logger): Transport
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return RequestLog
     */
    public function getLog(): RequestLog
    {
        return $this->log;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function get(Request $request): Response
    {
        if (strlen($request->getUrl()) > 0) {
            $delimiter = strpos($request->getUrl(), '?') ? '&' : '?' ;
            $url = $request->getUrl().$delimiter.$request->getData();

            $request->setUrl($url);
        }

        return $this->request($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function post(Request $request): Response
    {
        curl_setopt($this->client, CURLOPT_POST, true);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, $request->getData());

        return $this->request($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected function request(Request $request): Response
    {
        $start = microtime(true);

        curl_setopt($this->client, CURLOPT_URL, $request->getUrl());

        if (count($request->getHeaders()) > 0) {
            curl_setopt($this->client, CURLOPT_HTTPHEADER, $request->getHeaders());
        }

        if (true === $request->getBasicAuth()->hasBasicAuth()) {
            $pbAuth = vsprintf(
                '%s:%s',
                [
                    $request->getBasicAuth()->getUsername(),
                    $request->getBasicAuth()->getPassword()
                ]
            );

            curl_setopt($this->client, CURLOPT_USERPWD, $pbAuth);
            unset($pbAuth);
        }

        $response = curl_exec($this->client);
        $requestData = curl_getinfo($this->client);

        $rData = explode("\r\n\r\n", $response);
        $responseBodyIndex = count($rData) - 1;

        $response = $rData[$responseBodyIndex];
        unset($rData[$responseBodyIndex]);

        $headers = implode("\r\n\r\n", $rData);

        curl_close($this->client);

        $rTime = (string)round(microtime(true) - $start ,4);

        $this->log
            ->setMethod($request->getMethod())
            ->setUrl($request->getUrl())
            ->setData($request->getData())
            ->setResponseHeaders($headers)
            ->setResponse($response)
            ->setTime($rTime);

        if (isset($requestData[self::FIELD_INFO_HTTP_REQUEST_HEADERS])) {
            $this->log->setRequestHeaders($requestData[self::FIELD_INFO_HTTP_REQUEST_HEADERS]);
        }

        if (isset($requestData[self::FIELD_INFO_HTTP_RESPONSE_CODE])) {
            $this->log->setResponseHttpCode($requestData[self::FIELD_INFO_HTTP_RESPONSE_CODE]);
        }

        if (null !== $this->logger) {
            $this->logger->info(self::LOGGER_MESSAGE, $this->log->toArray());
        }

        return (new Response())
            ->setHttpCode($requestData[self::FIELD_INFO_HTTP_RESPONSE_CODE])
            ->setBody($response);
    }
}