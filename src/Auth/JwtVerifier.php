<?php

namespace CimpressJwtAuth\Auth;

use Firebase\JWT\CachedKeySet;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use InvalidArgumentException;
use UnexpectedValueException;
use Psr\Cache\CacheItemPoolInterface;

class JwtVerifier
{
    private string $payload;
    private $configs = [];

    /**
     * Constructor for the Token Verifier class.
     *
     */
    public function __construct(
        private Configuration $config
    ) {
    }

    public function decode(string $token)
    {
        if (empty($token)) {
            throw new \ValueError("Empty token", 401);
        }

        try {
            // The URI for the JWKS you wish to cache the results from
            $jwksUri = $this->config->getJwksDomain().".well-known/jwks.json";;

            // Create an HTTP client (can be any PSR-7 compatible HTTP client)
            $httpClient = new Client();

            // Create an HTTP request factory (can be any PSR-17 compatible HTTP request factory)
            $httpFactory = new HttpFactory();

            // Create a cache item pool (can be any PSR-6 compatible cache item pool)
            $cacheItemPool = $this->config->getJwksCache();

            $keySet = new CachedKeySet(
                $jwksUri,
                $httpClient,
                $httpFactory,
                $cacheItemPool,
                null, // $expiresAfter int seconds to set the JWKS to expire
                true  // $rateLimit    true to enable rate limit of 10 RPS on lookup of invalid keys
            );

            $decoded = JWT::decode($token, $keySet);
        } catch (InvalidArgumentException $e) {
            // provided key/key-array is empty or malformed.
        } catch (DomainException $e) {
            // provided algorithm is unsupported OR
            // provided key is invalid OR
            // unknown error thrown in openSSL or libsodium OR
            // libsodium is required but not available.
        } catch (SignatureInvalidException $e) {
            // provided JWT signature verification failed.
        } catch (BeforeValidException $e) {
            // provided JWT is trying to be used before "nbf" claim OR
            // provided JWT is trying to be used before "iat" claim.
        } catch (ExpiredException $e) {
            // provided JWT is trying to be used after "exp" claim.
        } catch (UnexpectedValueException $e) {
            // provided JWT is malformed OR
            // provided JWT is missing an algorithm / using an unsupported algorithm OR
            // provided JWT algorithm does not match provided key OR
            // provided key ID in key/key-array is empty or invalid.
        }

        if (empty($iss) || !in_array($iss, $this->config->getAllowedAuthIssuers())) {
            throw new \DomainException("Unsupported issuer", 401);
        }
    }
}