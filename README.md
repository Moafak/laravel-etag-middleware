# laravel-weak-etag-middleware
A Laravel middleware for adding **_Weak ETags_** to HTTP requests to improve response times

[![Build Status](https://travis-ci.org/moafak/laravel-weak-etag-middleware.svg?branch=master)](https://travis-ci.org/moafak/laravel-weak-etag-middleware)
[![Coverage Status](https://coveralls.io/repos/github/moafak/laravel-weak-etag-middleware/badge.svg?branch=master)](https://coveralls.io/github/moafak/laravel-weak-etag-middleware?branch=master)

Weak Etag vs Strong Etag
------------------------
Etag is a digest of the response content, usually with a hashing function.  
Strong etag means the content of the response is byte-for-byte identical.  
While weak etag means the content is symantically identical.  

Example of strong etag: `"f9bba821aec5e6b4607597cb500898f7"`  
Example of weak etag: `W/"f9bba821aec5e6b4607597cb500898f7"`  

Refer to the [blog post](https://moafak.github.io/blog/2018/02/28/weak-etags-laravel/) for more info.  

Installation
------------

Run the following command to install the package:

```bash
composer require moafak/laravel-weak-etag-middleware
```

Then just include this in your `app/Http/Kernel.php` in the appropriate place where you want to import the middleware:

```php
\moafak\WeakETagMiddleware\WeakETag::class
```
