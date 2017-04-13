<?php

namespace Colibri\Cache;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Interface CacheManagerInterface
 * @package Colibri\Cache
 */
interface CacheManagerInterface
{
  
  /**
   * @param $poolKey
   * @return CacheItemPoolInterface
   */
  public function getPool($poolKey);
  
  /**
   * @param $poolKey
   * @param CacheItemPoolInterface $pool
   * @return $this
   */
  public function setPool($poolKey, CacheItemPoolInterface $pool);
  
  /**
   * @param $poolKey
   * @return boolean
   */
  public function hasPool($poolKey);
  
  /**
   * @param $poolKey
   * @return $this
   */
  public function removePool($poolKey);
  
}