Shariff PHP Backend
===================

Shariff is used to determine how often a page is shared in social media, but without generating requests from the displaying page to the social sites.

![Shariff](shariff-logo.png)

This document describes the PHP backend. The following backends are also available:

* [shariff-backend-node](https://github.com/heiseonline/shariff-backend-node)
* [shariff-backend-perl](https://github.com/heiseonline/shariff-backend-perl)

Requirements
---------------

To run Shariff PHP Backend on your server you need:

* PHP 5.4 or greater

Installing the Shariff backend on you own server
------------------------------------------------

To run Shariff under a certain URL, unzip the [release](https://github.com/heiseonline/shariff-backend-php/releases) zip file and put contents of `build/` into a directory under the document root of your web server.

This zip file contains contains a configuration file `shariff.json`. The following configuration options are available:

| Key         | Type | Description |
|-------------|------|-------------|
| `cache`    | `object`  | File cache settings described below |
| `domain`   | `string` | Domain for which share counts may be requested |
| `services` | `array` | List of services to be enabled. Available: `Facebook`, `GooglePlus`, `Twitter` |

Cache settings:

| Key         | Type | Description |
|-------------|------|-------------|
| `ttl` | `integer` | Time that the counts are cached (in seconds) |
| `cacheDir` | `string` | Directory used for the cache. Default: system temp directory |

Testing your installation
-------------------------

If the backend runs under `http://example.com/my-shariff-backend/`, calling the URL `http://example.com/my-shariff-backend/?url=http%3A%2F%2Fwww.example.com` should return a JSON structure with numbers in it, e.g.:

```json
{"facebook":1452,"twitter":404,"googleplus":23,"linkedin":118,"flattr":0,"pinterest":3}
```


Shariff OO interface
--------------------

If you need more control, you can invoke Shariff in your own PHP code. The following snippet should get you started. `$options` are identical to those described above.

```php
use Heise\Shariff\Backend;

$options = [
	"domain"   => 'www.heise.de',
	"cache"    => ["ttl" => 1],
	"services" => ["Facebook", "GooglePlus", "Twitter", "LinkedIn", "Flattr", "Pinterest"]
]
$shariff = Backend->new($options);
$counts = $backend->get("http://www.heise.de/");
echo $counts["facebook"];
```
