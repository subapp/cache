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
   * @return mixed
   */
  public function retrieve($key);
  
  /**
   * @param $key
   * @param $data
   * @return mixed
   */
  public function save($key, $data);
  
  /**
   * @param $key
   * @return mixed
   */
  public function remove($key);
  
}