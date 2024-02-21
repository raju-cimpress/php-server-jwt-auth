<?php

namespace CimpressJwtAuth\Auth;

use Psr\Cache\CacheItemPoolInterface;

class Configuration
{
    public function __construct(
        private string                  $jwksDomain,
        private ?CacheItemPoolInterface $jwksCache = null,
        private int $jwksExpiresAfter = 86400,
        private array $allowedAuthIssuers = []
    )
    {
    }

    /**
     * @return string
     */
    public function getJwksDomain(): string
    {
        return $this->jwksDomain;
    }

    /**
     * @param string $jwksDomain
     * @return Configuration
     */
    public function setJwksDomain(string $jwksDomain): Configuration
    {
        $this->jwksDomain = $jwksDomain;
        return $this;
    }

    /**
     * @return CacheItemPoolInterface|null
     */
    public function getJwksCache(): ?CacheItemPoolInterface
    {
        return $this->jwksCache;
    }

    /**
     * @param CacheItemPoolInterface|null $jwksCache
     * @return Configuration
     */
    public function setJwksCache(?CacheItemPoolInterface $jwksCache): Configuration
    {
        $this->jwksCache = $jwksCache;
        return $this;
    }

    /**
     * @return int
     */
    public function getJwksExpiresAfter(): int
    {
        return $this->jwksExpiresAfter;
    }

    /**
     * @param int $jwksExpiresAfter
     * @return Configuration
     */
    public function setJwksExpiresAfter(int $jwksExpiresAfter): Configuration
    {
        $this->jwksExpiresAfter = $jwksExpiresAfter;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedAuthIssuers(): array
    {
        return $this->allowedAuthIssuers;
    }

    /**
     * @param array $allowedAuthIssuers
     * @return Configuration
     */
    public function setAllowedAuthIssuers(array $allowedAuthIssuers): Configuration
    {
        $this->allowedAuthIssuers = $allowedAuthIssuers;
        return $this;
    }
}