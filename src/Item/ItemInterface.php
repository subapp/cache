<?php

namespace Subapp\Cache\Item;

use Psr\Cache\CacheItemInterface;

/**
 * Interface ItemInterface
 * @package Subapp\Cache\Item
 */
interface ItemInterface extends CacheItemInterface
{
  
  /**
   * @return \DateTime
   */
  public function getExpiration();
  
}