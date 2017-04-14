<?php

namespace Colibri\Cache\Item;

use Colibri\Cache\InvalidArgumentException;

/**
 * Class CacheItem
 * @package Colibri\Cache
 */
class CacheItem implements ItemInterface
{
  
  const EXPIRATION = 'NOW +1 Year';
  
  /**
   * @var string
   */
  protected $key;
  
  /**
   * @var string
   */
  protected $value;
  
  /**
   * @var \DateTime
   */
  protected $expiration;
  
  /**
   * CacheItem constructor.
   * @param string $key
   * @param null|string $value
   * @param null|int|\DateTimeInterface $ttl
   */
  public function __construct($key, $value = null, $ttl = null)
  {
    $this->key = $key;
    $this->value = $value;

    $this->expiresAfter($ttl);
  }
  
  /**
   * @inheritDoc
   */
  public function getKey()
  {
    return $this->key;
  }
  
  /**
   * @inheritDoc
   */
  public function get()
  {
    return $this->isHit() ? $this->value : null;
  }
  
  /**
   * @inheritDoc
   */
  public function isHit()
  {
    return ($this->expiration > (new \DateTime()));
  }
  
  /**
   * @inheritDoc
   */
  public function set($value)
  {
    $this->value = $value;
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function expiresAt($expiration)
  {
    switch (true) {
      case ($expiration instanceOf \DateTime):
        $this->expiration = $expiration;
        break;
        
      case is_int($expiration):
        $this->expiration = new \DateTime();
        $this->expiration->setTimestamp($expiration);
        break;
  
      case (null === $expiration):
        $this->expiration = new \DateTime(static::EXPIRATION);
        break;

      default:
        throw new InvalidArgumentException('Cache item expect integer or \DateTime object');
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function expiresAfter($time)
  {
    $this->expiresAt(new \DateTime());
    
    switch (true) {
      case ($time instanceOf \DatePeriod):
        $this->expiration->add($time);
        break;
  
      case is_int($time):
        $time = $this->expiration->getTimestamp() + $time;
        $this->expiration->setTimestamp($time);
        break;
    
      case (null === $time):
        break;
    
      default:
        throw new InvalidArgumentException('Cache item expect integer or \DatePeriod object');
    }
  
    return $this;
  }
  
  /**
   * @return \DateTime
   */
  public function getExpiration()
  {
    return clone $this->expiration;
  }
  
}
