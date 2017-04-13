<?php

use Colibri\Cache\Adapter\FilesystemAdapter;
use Colibri\Cache\CacheItemPool;
use Colibri\Cache\CacheManager;
use Colibri\Cache\Item\CacheItem;
use Colibri\Cache\Serializer\PhpSerializer;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

include_once 'vendor/autoload.php';

error_reporting(1);

$manager = new CacheManager();

$adapter = new FilesystemAdapter(new Filesystem(new Local(__DIR__)), 'test_cache', new PhpSerializer());

$manager->setPool('entities', new CacheItemPool($adapter));
$pool = $manager->getPool('entities');

//$pool->save(new CacheItem('key', 123, 1200));
//$pool->save(new CacheItem('dt', new DateTime(), 123123123));
//$pool->save(new CacheItem('ok', new DateTime(), 10));

foreach ($pool->getItems(['key', 'test', 'ok', 'dt',]) as $item) {
 var_dump($item->isHit());
}