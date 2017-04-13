<?php

namespace Colibri\Cache\Serializer;

/**
 * Class MsgpackSerializer
 * @package Colibri\Cache\Serializer
 */
class MsgpackSerializer implements SerializerInterface
{
  
  /**
   * MsgpackSerializer constructor.
   */
  public function __construct()
  {
    if (!extension_loaded('msgpack')) {
      throw new \RuntimeException('Extension msgpack not installed on your server');
    }
  }
  
  /**
   * @inheritDoc
   */
  public function serialize($data)
  {
    return \msgpack_pack($data);
  }
  
  /**
   * @inheritDoc
   */
  public function unserialize($serialized)
  {
    return \msgpack_unpack($serialized);
  }
  
}
