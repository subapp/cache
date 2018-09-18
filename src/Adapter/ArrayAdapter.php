<?php

namespace Subapp\Cache\Adapter;

/**
 * Class ArrayAdapter
 * @package Subapp\Cache\Adapter
 */
class ArrayAdapter extends AbstractAdapter
{
  
  /**
   * @var array
   */
  private $cache = [];
  
  /**
   * @var int
   */
  private $hitsCount = 0;
  
  /**
   * @var int
   */
  private $missesCount = 0;
  
  /**
   * @inheritDoc
   */
  public function retrieve($key)
  {
    $parameters = $this->serializer->unserialize($this->cache[$key]);
    
    return $parameters;
  }
  
  /**
   * @inheritDoc
   */
  public function save($key, $data, $ttl = null)
  {
    $this->cache[$key] = $this->serializer->serialize([$key, $data, $ttl]);
    
    return true;
  }
  
  /**
   * @inheritDoc
   */
  public function remove($key)
  {
    unset($this->cache[$key]);
    
    return !isset($this->cache[$key]);
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    $this->cache = [];
    
    return true;
  }

}