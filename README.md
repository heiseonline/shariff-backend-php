# Shariff PHP Backend [![Build Status](https://travis-ci.org/heiseonline/shariff-backend-php.svg?branch=master)](https://travis-ci.org/heiseonline/shariff-backend-php) [![Dependency Status](https://www.versioneye.com/php/heise:shariff/badge.svg)](https://www.versioneye.com/php/heise:shariff) [![Code Climate](https://codeclimate.com/github/heiseonline/shariff-backend-php/badges/gpa.svg)](https://codeclimate.com/github/heiseonline/shariff-backend-php)


Shariff is used to determine how often a page is shared in social media, but without generating requests from the displaying page to the social sites.

![Shariff Logo © 2014 Heise Zeitschriften Verlag](http://www.heise.de/icons/ho/shariff-logo.png)

This document describes the PHP backend. The following backends are also available:

* [shariff-backend-node](https://github.com/heiseonline/shariff-backend-node)
* [shariff-backend-perl](https://github.com/heiseonline/shariff-backend-perl)

Supported services
------------------
- AddThis
- Facebook
- Flattr
- GooglePlus
- LinkedIn
- Pinterest
- Reddit
- StumbleUpon
- Xing

Requirements
------------

To run Shariff PHP Backend on your server you need one of these PHP versions:

* 5.5
* 5.6
* 7.0

Older versions and HHVM are not supported.

Installing the Shariff backend on you own server
------------------------------------------------

To run Shariff under a certain URL, unzip the [release](https://github.com/heiseonline/shariff-backend-php/releases) zip file into a directory under the document root of your web server.

This zip file contains a configuration file `shariff.json`. The following configuration options are available:

| Key         | Type | Description |
|-------------|------|-------------|
| `cacheClass` | `string` | *Optional* Cache class name. Has to implement `Heise\Shariff\CacheInterface`. Defaults to internal Zend Cache. |
| `cache` | `object`  | File cache settings, which are passed on to the Cache class. See description below. |
| `domains` | `array` | Domains for which share counts may be requested. If empty, all domains are allowed. |
| `services` | `array` | List of services to be enabled. See [Supported services](#supported-services). |

##### Cache settings:

By default Shariff uses the Filesystem cache. By specifying a different adapter from Zend\Cache\Storage\Adapter you can tell Shariff to use another cache. Also you can specify options for that cache adapter

| Key         | Type | Description |
|-------------|------|-------------|
| `ttl` | `integer` | Time that the counts are cached (in seconds) |
| `cacheDir` | `string` | Directory used for the cache. Default: system temp directory |
| `adapter` | `string` | Name of cache adapter (e.g. Apc, Memcache, etc.) |
| `adapterOptions` | `object` | Options for the cache adapter |

*These option apply for the default Cache class (`ZendCache`) only. If you implement custom caching, you can specify your own options.*

##### Client options

The backend uses [Guzzle](http://docs.guzzlephp.org/en/latest/) as HTTP client. Guzzle has many options that you can set, e.g. timeout and connect_timeout. See http://docs.guzzlephp.org/en/latest/request-options.html for a detailed list.
In order to set those options pass them in the json with the key "client".

| Key         | Type | Description |
|-------------|------|-------------|
| `client` | `object` | Guzzle request options |

##### Service Settings

To pass config options to a service, you can add them to the json as well under the name of the service. Currently only the Facebook service has options for an facebook application id and client secret in order to use the graph api id method to get the current share count.

| Key         | Type | Description |
|-------------|------|-------------|
| `servicename` | `object` | options for the service |

##### Facebook service options

To use the graph api id method to fetch the share count you need to set up an application at facebook.com and pass in the application id and client secret to the options. It seems that the id method returns the most current share count, but it can be only used with an registered application.

| Key         | Type | Description |
|-------------|------|-------------|
| `app_id` | `string` | the id of your facebook application |
| `secret` | `string` | the client secret of your facebook application |

##### Full config example

```js
{
	"cacheClass": "Heise\\Shariff\\ZendCache",
	"cache": {
		"ttl": 60,
		"cacheDir": "/tmp/shariff/cache",
		"adapter": "Filesystem",
		"adapterOptions": {
			// ...
		}
	},
	"client": {
		"timeout": 4.2,
		// ... (see "Client options")
	},
	"domains": [
		"www.example.com",
		"www.example.net"
	],
	"services": [
		"GooglePlus",
		"Facebook",
		"LinkedIn",
		"Reddit",
		"StumbleUpon",
		"Flattr",
		"Pinterest",
		"Xing",
		"AddThis"
	],
	"Facebook": {
		"app_id": "1234567890",
		"secret": "terces"
	}
}
```


Testing your installation
-------------------------

If the backend runs under `http://example.com/my-shariff-backend/`, calling the URL `http://example.com/my-shariff-backend/?url=http%3A%2F%2Fwww.example.com` should return a JSON structure with numbers in it, e.g.:

```json
{"facebook":1452,"googleplus":23,"linkedin":118,"reddit":7,"stumbleupon":4325,"flattr":0,"pinterest":3,"addthis":33}
```


Shariff OO interface
--------------------

If you need more control, you can invoke Shariff in your own PHP code. The following snippet should get you started. `$options` are identical to those described above.

```php
use Heise\Shariff\Backend;

$options = [
	"domains"  => ["www.heise.de", "www.ct.de"],
	"cache"    => ["ttl" => 1],
	"services" => ["Facebook", "GooglePlus", "LinkedIn", "Reddit", "StumbleUpon", "Flattr", "Pinterest", "AddThis"]
];
$shariff = new Backend($options);
$counts = $shariff->get("http://www.heise.de/");
echo $counts["facebook"];
```
