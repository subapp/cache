<?php

namespace Colibri\Cache\Adapter;

/**
 * Class ArrayAdapter
 * @package Colibri\Cache\Adapter
 */
class ArrayAdapter extends AbstractAdapter
{
  
  /**
   * @var array
   */
  protected $cache = [];
  
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