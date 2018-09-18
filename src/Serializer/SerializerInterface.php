<?php

namespace Subapp\Cache\Serializer;

/**
 * Interface SerializerInterface
 * @package Subapp\Cache\Serializer
 */
interface SerializerInterface
{
  
  /**
   * @param $data
   * @return string
   */
  public function serialize($data);
  
  /**
   * @param $serialized
   * @return mixed
   */
  public function unserialize($serialized);
  
}