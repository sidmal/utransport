<?php

namespace UTransport\Transport;

/**
 * Class BasicAuth
 * @package UTransport\Transport
 * @author Dmitriy Sinichkin <dmitriy.sinichkin@gmail.com>
 * @version 1.0
 */
class BasicAuth
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * BasicAuth constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return BasicAuth
     */
    public function setUsername(string $username): BasicAuth
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return BasicAuth
     */
    public function setPassword(string $password): BasicAuth
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBasicAuth(): bool
    {
        return null !== $this->username && null !== $this->password;
    }
}