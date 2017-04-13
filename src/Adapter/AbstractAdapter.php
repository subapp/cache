<?php

namespace Colibri\Cache\Adapter;

use Colibri\Cache\Serializer\PhpSerializer;
use Colibri\Cache\Serializer\SerializerInterface;

/**
 * Class AbstractAdapter
 * @package Colibri\Cache\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
  
  /**
   * @var SerializerInterface
   */
  protected $serializer;
  
  /**
   * AbstractAdapter constructor.
   * @param SerializerInterface $serializer
   */
  public function __construct(SerializerInterface $serializer = null)
  {
    $this->serializer = $serializer ?: new PhpSerializer();
  }
  
  /**
   * @return SerializerInterface
   */
  public function getSerializer()
  {
    return $this->serializer;
  }
  
  /**
   * @param SerializerInterface $serializer
   */
  public function setSerializer(SerializerInterface $serializer)
  {
    $this->serializer = $serializer;
  }
  
}