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
    $item = new CacheItem(...$this->adapter->retrieve($key));
    
    return $item;
  }
  
  /**
   * @inheritDoc
   */
  public function getItems(array $keys = [])
  {
    // TODO: Implement getItems() method.
  }
  
  /**
   * @inheritDoc
   */
  public function hasItem($key)
  {
    // TODO: Implement hasItem() method.
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    // TODO: Implement clear() method.
  }
  
  /**
   * @inheritDoc
   */
  public function deleteItem($key)
  {
    // TODO: Implement deleteItem() method.
  }
  
  /**
   * @inheritDoc
   */
  public function deleteItems(array $keys)
  {
    // TODO: Implement deleteItems() method.
  }
  
  /**
   * @inheritDoc
   */
  public function save(CacheItemInterface $item)
  {
    /** @var CacheItem $item */
    $this->adapter->save($item->getKey(), $item->get(), $item->getTtl());
    
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
