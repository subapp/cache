<?php

use Colibri\Cache\Adapter\ArrayAdapter;
use Colibri\Cache\CacheItemPool;
use Colibri\Cache\CacheManager;
use Colibri\Cache\Item\CacheItem;
use Colibri\Cache\Serializer\PhpSerializer;

include_once 'vendor/autoload.php';

error_reporting(1);

$manager = new CacheManager();

$pool = new CacheItemPool(new ArrayAdapter(new PhpSerializer()));

$manager->setPool('entities', $pool);

$datetime = new DateTime();

$pool->save(new CacheItem('key', 123, 1200));
$pool->save(new CacheItem('dt', $datetime, 351233));

var_dump($pool, $pool->getItem('dt'));