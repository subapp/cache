<?php

namespace Colibri\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * Class CacheItem
 * @package Colibri\Cache
 */
class CacheItem implements CacheItemInterface
{
  
  const EXPIRATION = 'NOW +1 Month';
  
  /**
   * @var string
   */
  protected $key;
  
  /**
   * @var string
   */
  protected $value;
  
  /**
   * @var bool
   */
  protected $hit = false;
  
  /**
   * @var \DateTimeInterface
   */
  protected $expiration;
  
  /**
   * CacheItem constructor.
   * @param string $key
   * @param null|string $value
   * @param null|int|\DateTimeInterface $ttl
   * @param bool $hit
   */
  public function __construct($key, $value = null, $ttl = null, $hit = false)
  {
    $this->key = $key;
    $this->value = $value;
    $this->hit = $hit;
    
    $this->expiresAfter($ttl);
  }
  
  /**
   * @inheritDoc
   */
  public function getKey()
  {
    // TODO: Implement getKey() method.
  }
  
  /**
   * @inheritDoc
   */
  public function get()
  {
    return $this->hit ? $this->value : null;
  }
  
  /**
   * @inheritDoc
   */
  public function isHit()
  {
    // TODO: Implement isHit() method.
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
      case ($expiration instanceOf \DateTimeInterface):
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
        throw new InvalidArgumentException('Integer or \DateTime object expected');
    }
    
    return $this;
  }
  
  /**
   * @inheritDoc
   */
  public function expiresAfter($time)
  {
    switch (true) {
      case ($time instanceOf \DateTimeInterface):
        $this->expiration = $time;
        break;
  
      case ($time instanceOf \DatePeriod):
      case is_int($time):
        $this->expiration = new \DateTime();
        ($time instanceOf \DatePeriod)
          ? $this->expiration->add($time) : $this->expiration->setTimestamp($time);
        break;
    
      case (null === $time):
        $this->expiration = new \DateTime(static::EXPIRATION);
        break;
    
      default:
        throw new InvalidArgumentException('Integer or \DateTime object expected');
    }
    
  }
  
  /**
   * @return int
   */
  public function getItemTtl()
  {
    return $this->expiration->getTimestamp() - time();
  }
  
}
