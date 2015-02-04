<?php
abstract class CacheInterface {
	abstract protected function getCached($key, &$isFound);
	abstract protected function setCached($key, $value);
	abstract protected function deleteCached($key);
	abstract protected function flushCache();
}
?>
