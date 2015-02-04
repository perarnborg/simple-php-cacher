# SIMPLE PHP CACHER
Simple caching class for php.

Include cacher class:

require_once 'simple-php-cacher/simple_php_cacher.php'

Set time to live, choose cache implementation and congure it in cache_settings.php

Start caching:

```
$cacher = new SimplePhpCacher();

$isCached = false;
$data = $cacher->get('cache_key', $isCached);

if(!$isCached) {
  $data = getData('cache_key');
  $cacher->set('cache_key', $data);
}
```
