<?php

namespace Colibri\Cache\Serializer;

/**
 * Class JsonSerilizer
 * @package Colibri\Cache\Serializer
 */
class JsonSerilizer implements SerializerInterface
{
  
  /**
   * @inheritDoc
   */
  public function serialize($data)
  {
    return json_encode($data);
  }
  
  /**
   * @inheritDoc
   */
  public function unserialize($serialized)
  {
    return json_decode($serialized);
  }
  
}