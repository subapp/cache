<?php

/**
 * Class UserEntity
 */
class UserEntity
{
  
  /**
   * @var int
   */
  public $id;
  
  /**
   * @var string
   */
  public $email;
  
  /**
   * @var string
   */
  public $name;
  
  /**
   * @var \DateTime
   */
  public $created;
  
  /**
   * @param array $arrayData
   * @return static
   */
  static public function fromArray(array $arrayData)
  {
    $entity = new static();
    
    foreach ($arrayData as $property => $value) {
      $entity->$property = $value;
    }
    
    return $entity;
  }
  
}