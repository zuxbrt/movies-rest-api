<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a></p>

# Movies REST API

## Postman API Documentation
Postman API documentation is available [here](https://documenter.getpostman.com/view/4336607/2s9YRDyq6P)

## Requirements
<p>PHP: ^8.1</p>
<p>composer: 2.4.1</p>

## Code coverage
<p>Code coverage results with current seeder settings are available as generated html report in: <strong>/tests/coverage/index.html</strong></p>

In order to run tests on your machine, it's neccessary:
- to create <strong>.env.testing</strong> according to the .env.testing.example</li>
- run **php artisan key:generate --env=testing** (JWT auth uses APP_KEY)
- make sure you have xdebug extension enabled and configured
- run following command: **composer test**, which will generate html coverage report in /tests/coverage

## CORS
<p>Current CORS settings are:</p>

```
'paths' => ['api/*'],

'allowed_methods' => ['*'],

'allowed_origins' => ['*'], // all for now

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],

'exposed_headers' => [],

'max_age' => 0,

'supports_credentials' => false,
```

## Caching
```
CACHE_DRIVER=file
```
<p>Results for [GET]/api/favorites: (with current seeder)</p>
<p>Without cache:&nbsp;&nbsp;&nbsp;<strong>~430ms</strong></p>
<p>With cache:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>~320ms</strong></p>