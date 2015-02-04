# SIMPLE PHP CACHER
Simple caching class for php.

Include cacher class:

require_once 'simple-php-cacher/simple_php_cacher.php'

Set time to live, choose cache implementation and congure it in config.php

Start caching:

```
$cacher = new SimplePhpCacher();

$isCached = false;
$data = $cacher->get(array('param1', 'param2', $isCached);

if(!$isCached) {
  $data = getData('param1', 'param2');
  $cacher->set(array('param1', 'param2', $data);
}
```
