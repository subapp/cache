<?php

namespace Subapp\Cache\Serializer;

/**
 * Class MsgPackSerializer
 * @package Subapp\Cache\Serializer
 */
class MsgPackSerializer implements SerializerInterface
{
  
  /**
   * MsgpackSerializer constructor.
   */
  public function __construct()
  {
    if (!extension_loaded('msgpack')) {
      throw new \RuntimeException('Extension msgPack not installed on your server');
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
