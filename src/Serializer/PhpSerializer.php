<?php

namespace Subapp\Cache\Serializer;

/**
 * Class PhpSerializer
 * @package Subapp\Cache\Serializer
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