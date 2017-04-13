<?php

namespace Colibri\Cache;

use Colibri\Cache\Adapter\AdapterInterface;
use Colibri\Cache\Serializer\SerializerInterface;
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
    return new CacheItem($key, $this->adapter->retrieve($key));
  }
  
  /**
   * @inheritDoc
   */
  public function getItems(array $keys = array())
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
    $this->adapter->save($item->getKey(), $item->get());
  }
  
  /**
   * @inheritDoc
   */
  public function saveDeferred(CacheItemInterface $item)
  {
    // TODO: Implement saveDeferred() method.
  }
  
  /**
   * @inheritDoc
   */
  public function commit()
  {
    // TODO: Implement commit() method.
  }
  
  /**
   * @return AdapterInterface
   */
  public function getAdapter()
  {
    return $this->adapter;
  }
  
}
