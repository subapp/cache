<?php

namespace Subapp\Cache\Adapter;

use Subapp\Cache\Serializer\SerializerInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;

/**
 * Class FilesystemAdapter
 * @package Subapp\Cache\Adapter
 */
class FilesystemAdapter extends AbstractAdapter
{
  
  /**
   * @var Filesystem
   */
  protected $filesystem;
  
  /**
   * @var string
   */
  protected $folder;
  
  /**
   * FilesystemAdapter constructor.
   * @param Filesystem $filesystem
   * @param string $folder
   * @param SerializerInterface|null $serializer
   */
  public function __construct(Filesystem $filesystem, $folder, SerializerInterface $serializer = null)
  {
    parent::__construct($serializer);
    
    $this->folder = $folder;
    
    $this->filesystem = $filesystem;
    $this->filesystem->createDir($this->folder);
  }
  
  /**
   * @inheritDoc
   */
  public function retrieve($key)
  {
    $filepath = $this->createFilepath($key);
    
    try {
      return $this->unserialize($this->filesystem->read($filepath));
    } catch (FileNotFoundException $exception) {}
    
    return false;
  }
  
  /**
   * @inheritDoc
   */
  public function save($key, $data, $ttl = null)
  {
    $filepath = $this->createFilepath($key);

    try {
      return $this->filesystem->update($filepath, $this->serialize([$key, $data, $ttl]));
    } catch (FileNotFoundException $exception) {
      return $this->filesystem->write($filepath, $this->serialize([$key, $data, $ttl]));
    }
  }
  
  /**
   * @inheritDoc
   */
  public function remove($key)
  {
    $filepath = $this->createFilepath($key);
    
    try {
      return $this->filesystem->delete($filepath);
    } catch (FileNotFoundException $e) { }
  
    return true;
  }
  
  /**
   * @inheritDoc
   */
  public function clear()
  {
    $this->filesystem->deleteDir($this->folder);
    $this->filesystem->createDir($this->folder);
    
    return true;
  }
  
  /**
   * @param $key
   * @return string
   */
  private function createFilepath($key)
  {
    return sprintf('%s/%s', $this->folder, $this->createFilename($key));
  }
  
  /**
   * @param $key
   * @return string
   */
  private function createFilename($key)
  {
    return sprintf('%s_%s.data', strtoupper(date('YMd')), hash('sha256', $key));
  }
  
}