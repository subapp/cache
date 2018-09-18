<?php

namespace Subapp\Cache\Pool;

use Subapp\Cache\Adapter\AdapterInterface;
use Subapp\Cache\Item\CacheItem;
use Subapp\Cache\Item\ItemInterface;
use Psr\Cache\CacheItemInterface;

/**
 * Class CacheItemPool
 * @package Subapp\Cache
 */
class CacheItemPool implements PoolInterface
{
  
  /**
   * @var AdapterInterface
   */
  protected $adapter;
  
  /**
   * @var array|CacheItemInterface[]
   */
  protected $deferred = [];
  
  /**
   * CacheItemPool constructor.
   * @param AdapterInterface $adapter
   */
  public function __construct(AdapterInterface $adapter)
  {
    $this->adapter = $adapter;
  }
  
  
  /**
   * @param string $key
   * @return ItemInterface|CacheItemInterface
   */
  public function getItem($key)
  {
    if (isset($this->deferred[$key])) {
      return $this->deferred[$key];
    }
    
    $retrieved = $this->adapter->retrieve($key);
    
    if (false === $retrieved) {
      $retrieved = [$key, null, time()];
    }
    
    list($key, $value, $timestamp) = $retrieved;
    $ttl = $timestamp - time();
    
    return new CacheItem($key, $value, $ttl);
  }
  
  /**
   * @param $key
   * @return mixed|null|string
   */
  public function getValue($key)
  {
    return $this->getItem($key)->get();
  }
  
  /**
   * @inheritDoc
   */
  public function getItems(array $keys = [])
  {
    $collection = [];
    
    foreach ($keys as $key) {
      $collection[$key] = $this->getItem($key);
    }
    
    return $collection;
  }
  
  /**
   * @inheritDoc
   */
  public function hasItem($key)
  {
    return $this->getItem($key)->isHit() || $this->hasDeferred($key);
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    return $this->adapter->clear();
  }
  
  /**
   * @inheritDoc
   */
  public function deleteItem($key)
  {
    return $this->adapter->remove($key);
  }
  
  /**
   * @inheritDoc
   */
  public function deleteItems(array $keys)
  {
    $success = true;
    
    foreach ($keys as $key) {
      $success = $success && ($this->deleteItem($key) || $this->deleteDeferred($key));
    }
    
    return $success;
  }
  
  /**
   * @inheritDoc
   */
  public function save(CacheItemInterface $item)
  {
    /** @var CacheItem $item */
    $this->adapter->save($item->getKey(), $item->get(), $item->getExpiration()->getTimestamp());
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function saveDeferred(CacheItemInterface $item)
  {
    $this->deferred[$item->getKey()] = $item;
    
    return true;
  }
  
  /**
   * @param $key
   * @return bool
   */
  public function deleteDeferred($key)
  {
    $success = $this->hasDeferred($key);
  
    unset($this->deferred[$key]);
    
    return $success;
  }
  
  /**
   * @inheritDoc
   */
  public function hasDeferred($key)
  {
    return isset($this->deferred[$key]);
  }
  
  /**
   * @inheritDoc
   */
  public function commit()
  {
    $success = true;
    
    while ($cacheItem = array_shift($this->deferred)) {
      $success = $success && $this->save($cacheItem);
    }
    
    return $success;
  }
  
  /**
   * @return AdapterInterface
   */
  public function getAdapter()
  {
    return $this->adapter;
  }

}
