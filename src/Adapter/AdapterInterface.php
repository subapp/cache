<?php

namespace Colibri\Cache\Adapter;

/**
 * Interface AdapterInterface
 * @package Colibri\Cache\Adapter
 */
interface AdapterInterface
{
  
  /**
   * @param $key
   * @return array
   */
  public function retrieve($key);
  
  /**
   * @param $key
   * @param $data
   * @param null|int $ttl
   * @return boolean
   */
  public function save($key, $data, $ttl = null);
  
  /**
   * @param $key
   * @return mixed
   */
  public function remove($key);
  
}