<?php

namespace Subapp\Cache\Adapter;

use Subapp\Cache\Serializer\SerializerInterface;
use Predis\Client;

/**
 * Class PredisAdapter
 * @package Subapp\Cache\Adapter
 */
class PredisAdapter extends AbstractAdapter
{
  
  /**
   * @var Client
   */
  private $client;
  
  /**
   * PredisAdapter constructor.
   * @param Client $client
   * @param SerializerInterface $serializer
   */
  public function __construct(Client $client, SerializerInterface $serializer)
  {
    parent::__construct($serializer);
    
    $this->client = $client;
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
  
    $response = ($ttl > 0)
      ? $this->client->setex($key, $ttl, $data) : $this->client->set($key, $data);
  
    return in_array($response, [true, 'OK'], true);
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
    $response = $this->client->flushdb();
    
    return in_array($response, [true, 'OK'], true);
  }
  
}