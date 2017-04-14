<?php

namespace Colibri\Cache;

use Colibri\Cache\Pool\PoolInterface;

/**
 * Interface CacheManagerInterface
 * @package Colibri\Cache
 */
interface CacheManagerInterface
{
  
  /**
   * @param $poolKey
   * @return PoolInterface
   */
  public function getPool($poolKey);
  
  /**
   * @param $poolKey
   * @param PoolInterface $pool
   * @return $this
   */
  public function setPool($poolKey, PoolInterface $pool);
  
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