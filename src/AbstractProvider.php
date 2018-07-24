<?php

namespace UTransport;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use UTransport\Helpers\ExceptionHelper;
use UTransport\Transport\Request;
use UTransport\Transport\Response;
use UTransport\Transport\Transport;

/**
 * Class AbstractProvider
 * @package UTransport
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class AbstractProvider
{
    const CACHE_LOG_MESSAGE = 'Get result from cache error';

    /**
     * @var CacheItemPoolInterface|null
     */
    private $cache;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @var Transport
     */
    private $transport;

    /**
     * AbstractProvider constructor.
     *
     * @param CacheItemPoolInterface|null $cache
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        CacheItemPoolInterface $cache = null,
        LoggerInterface $logger = null
    )
    {
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * @param CacheItemPoolInterface $cache
     * @return AbstractProvider
     */
    public function setCache(CacheItemPoolInterface $cache): AbstractProvider
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @param LoggerInterface $logger
     * @return AbstractProvider
     */
    public function setLogger(LoggerInterface $logger): AbstractProvider
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getCacheKey(Request $request)
    {
        return md5($request->getUrl().$request->getData());
    }

    /**
     * @return Transport
     */
    public function getTransport()
    {
        if (null === $this->transport) {
            $this->transport = new Transport();
        }

        return $this->transport;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function doRequest(Request $request): Response
    {
        $cacheKey = $this->getCacheKey($request);
        $cacheItem = null;

        if (null !== $this->cache) {
            try {
                $cacheItem = $this->cache->getItem($cacheKey);
            } catch (InvalidArgumentException $e) {
                $this->logger
                    ->critical('Get result from cache error', ExceptionHelper::getLoggerTrace($e));

                return new Response(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            }

            if (true === $cacheItem->isHit()) {
                return (new Response())->setBody($cacheItem->get());
            }
        }

        /** @var Response $response */
        $response = $this->getTransport()->{$request->getMethod()}($request);

        if (false === $response->isSuccessfully()) {
            return $response;
        }

        if (null !== $cacheItem) {
            $cacheItem
                ->set($response->getBody())
                ->expiresAt((new \DateTime())->modify('+1 day'));
        }

        return $response;
    }
}