<?php

namespace Colibri\Cache\Serializer;

/**
 * Class PhpSerializer
 * @package Colibri\Cache\Serializer
 */
class PhpSerializer implements SerializerInterface
{
  
  /**
   * @inheritDoc
   */
  public function serialize($data)
  {
    return serialize($data);
  }
  
  /**
   * @inheritDoc
   */
  public function unserialize($serialized)
  {
    return unserialize($serialized);
  }
  
}