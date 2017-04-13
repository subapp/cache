<?php

namespace Colibri\Cache\Adapter;

use Colibri\Cache\Serializer\SerializerInterface;

abstract class AbstractAdapter implements AdapterInterface
{
  
  /**
   * @var SerializerInterface
   */
  protected $serializer;
  
  
  
}