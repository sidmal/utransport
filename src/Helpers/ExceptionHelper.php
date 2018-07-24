<?php

namespace UTransport\Helpers;

/**
 * Class ExceptionHelper
 * @package UTransport
 * @copyright Copyright (с) 2018.
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class ExceptionHelper
{
    /**
     * @param \Exception $e
     * @return array
     */
    public static function getLoggerTrace(\Exception $e)
    {
        return ['file' => $e->getFile(), 'line' => $e->getLine(), 'message' => $e->getMessage()];
    }
}