<?php

namespace Colibri\Cache;

use Colibri\Cache\Adapter\AdapterInterface;
use Colibri\Cache\Item\CacheItem;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class CacheItemPool
 * @package Colibri\Cache
 */
class CacheItemPool implements CacheItemPoolInterface
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
   * @inheritDoc
   */
  public function getItem($key)
  {
    if (isset($this->deferred[$key])) {
      return $this->deferred[$key];
    }
    
    $retrieved = $this->adapter->retrieve($key);
    
    if (false === $retrieved) {
      $retrieved = [$key, null, null];
    }
  
    // @todo hardcode
    $retrieved[2] = $retrieved[2] - time();
    
    return new CacheItem(...$retrieved);
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
    return $this->getItem($key)->isHit() || isset($this->deferred[$key]);
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
    $success = isset($this->deferred[$key]);
  
    unset($this->deferred[$key]);
    
    return $success;
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
