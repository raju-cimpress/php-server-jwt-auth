<?php
$loader = require 'vendor/autoload.php';
$loader->add('AppName', __DIR__.'/../src/');

$token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1qbENNemxCTnpneE1ETkJSVFpHTURFd09ETkRSalJGTlRSR04wTXpPRUpETnpORlFrUTROUSJ9.eyJodHRwczovL2NsYWltcy5jaW1wcmVzcy5pby93YXMiOlsiYWRmc3xSYWp1Lk1vdXJ5YUBwaXhhcnRwcmludGluZy5jb20iXSwiaHR0cHM6Ly9jbGFpbXMuY2ltcHJlc3MuaW8vZW1haWwiOiJSYWp1Lk1vdXJ5YUBwaXhhcnRwcmludGluZy5jb20iLCJodHRwczovL2NsYWltcy5jaW1wcmVzcy5pby9jYW5vbmljYWxfaWQiOiJSYWp1Lk1vdXJ5YUBwaXhhcnRwcmludGluZy5jb20iLCJodHRwczovL2NsYWltcy5jaW1wcmVzcy5pby9hY2NvdW50Ijoic1V3Sm5jbzFWN1J0cWJMNlc4RHVROCIsImh0dHBzOi8vY2xhaW1zLmNpbXByZXNzLmlvL2NpbXByZXNzX2ludGVybmFsIjp0cnVlLCJpc3MiOiJodHRwczovL2NpbXByZXNzLmF1dGgwLmNvbS8iLCJzdWIiOiJ3YWFkfEpqMzZwbG5iS1FoN01UX1RvRklOYjFfaDBEd3dxOGNtQzJ1VDFRTDZZQUEiLCJhdWQiOiJodHRwczovL2FwaS5jaW1wcmVzcy5pby8iLCJpYXQiOjE3MDg1ODgwMTQsImV4cCI6MTcwODY3NDQxNCwiYXpwIjoiU1Qwd3dPYzBSYXZLNlA2aGhBUFo5T2MyWEZEMmRHVUYiLCJndHkiOiJwYXNzd29yZCJ9.NdEvFyYTav9kdhp4rJOO32e_WD1RzZ4daxqxivR8e89IDiKrswMuj3ERCxdvMWrpzm4eiVZ-THwMlIcMNj29agW1WX-1gDI2sEVpkLJaqarCscQOaKOUGyPweAOH7BK3Qo_8i9CkE4Y_fIG_lq78S0fdiLDZ1eJxEc5QTX6JldY4UTAKWBljGmkzGyNLxNfV6ywYPEm9fx_gNvhzp0z2jgBmjLGR44U_Gaofc_iZnEMSJ4M52kXB_FGwQMI50J2UaEhb_8jl6i7N63gmh5gWKFYImEehVqloxtoVbzJpJGNEIGsxKurNPY7DvSGuK5GnBFmoK_MgT7IepwoAU6BXQg";

$cache = new \Symfony\Component\Cache\Adapter\ApcuAdapter(

    // a string prefixed to the keys of the items stored in this cache
    $namespace = 'jwks',

    // the default lifetime (in seconds) for cache items that do not define their
    // own lifetime, with a value 0 causing items to be stored indefinitely (i.e.
    // until the APCu memory is cleared)
    $defaultLifetime = 0,

    // when set, all keys prefixed by $namespace can be invalidated by changing
    // this $version string
    $version = null
);

$config = new \CimpressJwtAuth\Auth\Configuration(
    "https://oauth.cimpress.io/.well-known/jwks.json",
    $cache
);

$jwtVerifyer = new \CimpressJwtAuth\Auth\JwtVerifier($config);
try {
    $jwtVerifyer->decode($token);
    var_dump($jwtVerifyer);
} catch (Throwable $throwable) {
    echo $throwable->getTraceAsString();
}