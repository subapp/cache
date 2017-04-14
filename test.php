<?php

use Colibri\Cache\Adapter\FilesystemAdapter;
use Colibri\Cache\CacheManager;
use Colibri\Cache\Pool\CacheItemPool;
use Colibri\Cache\Serializer\PhpSerializer;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

include_once 'vendor/autoload.php';
include_once 'entity.php';

error_reporting(1);

$manager = new CacheManager();

$adapter = new FilesystemAdapter(new Filesystem(new Local(__DIR__)), 'test_cache', new PhpSerializer());

$manager->setPool('entities', new CacheItemPool($adapter));
$pool = $manager->getPool('entities');

$entity = UserEntity::fromArray([
  'id' => 87,
  'name' => 'Ivan Hontarenko',
  'email' => 'stewie.dev@gmail.com',
  'created' => new DateTime('NOW -123 days'),
]);

$entityCache = $pool->getItem($entity->id);

if (!$entityCache->isHit()) {
  $entityCache->expiresAfter(3600);
  $entityCache->set($entity);
  $pool->save($entityCache);
}

var_dump($pool->getValue($entity->id), $entityCache->getExpiration()->format('Y-m-d H:i:s'));

