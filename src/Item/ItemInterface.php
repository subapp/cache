<?php

namespace Colibri\Cache\Item;

use Psr\Cache\CacheItemInterface;

/**
 * Interface ItemInterface
 * @package Colibri\Cache\Item
 */
interface ItemInterface extends CacheItemInterface
{
  
  /**
   * @return \DateTime
   */
  public function getExpiration();
  
}