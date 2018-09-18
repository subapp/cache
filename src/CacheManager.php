<?php

namespace Subapp\Cache;

use Subapp\Cache\Pool\PoolInterface;

/**
 * Class CacheManager
 * @package Subapp\Cache
 */
class CacheManager implements CacheManagerInterface, \ArrayAccess
{
  
  /**
   * @var array
   */
  protected $collection = [];
  
  /**
   * CacheManager constructor.
   */
  public function __construct()
  {
    
  }
  
  /**
   * @inheritDoc
   */
  public function setPool($poolKey, PoolInterface $pool)
  {
    $this->collection[$poolKey] = $pool;
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function getPool($poolKey)
  {
    return $this->hasPool($poolKey) ? $this->collection[$poolKey] : null;
  }
  
  /**
   * @inheritDoc
   */
  public function hasPool($poolKey)
  {
    return isset($this->collection[$poolKey]);
  }
  
  /**
   * @inheritDoc
   */
  public function removePool($poolKey)
  {
    if ($this->hasPool($poolKey)) {
      $this->getPool($poolKey)->clear();
      unset($this->collection[$poolKey]);
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function offsetExists($offset)
  {
    return $this->hasPool($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetGet($offset)
  {
    return $this->getPool($offset);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetSet($offset, $value)
  {
    $this->setPool($offset, $value);
  }
  
  /**
   * @inheritDoc
   */
  public function offsetUnset($offset)
  {
    $this->removePool($offset);
  }
  
}