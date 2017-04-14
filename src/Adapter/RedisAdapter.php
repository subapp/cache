<?php

namespace Colibri\Cache\Adapter;

use Colibri\Cache\Serializer\SerializerInterface;

/**
 * Class RedisAdapter
 * @package Colibri\Cache\Adapter
 */
class RedisAdapter extends AbstractAdapter
{
  
  /**
   * @var \Redis
   */
  protected $client;
  
  /**
   * RedisAdapter constructor.
   * @param \Redis $redis
   * @param SerializerInterface $serializer
   */
  public function __construct(\Redis $redis, SerializerInterface $serializer)
  {
    parent::__construct($serializer);
    
    $this->client = $redis;
  }
  
  /**
   * @inheritDoc
   */
  public function retrieve($key)
  {
    if (null === ($serialized = $this->client->get($key))) {
      return false;
    }
    
    return $this->unserialize($serialized);
  }
  
  /**
   * @inheritDoc
   */
  public function save($key, $data, $ttl = null)
  {
    $data = $this->serialize([$key, $data, $ttl]);
    
    if ($ttl > 0) {
      return $this->client->setex($key, $ttl, $data);
    }
    
    return $this->client->set($key, $data);
  }
  
  /**
   * @inheritDoc
   */
  public function remove($key)
  {
    return $this->client->del($key) >= 0;
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    return $this->client->flushdb();
  }
  
}