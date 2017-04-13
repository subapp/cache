<?php

namespace Colibri\Cache\Serializer;

/**
 * Interface SerializerInterface
 * @package Colibri\Cache\Serializer
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