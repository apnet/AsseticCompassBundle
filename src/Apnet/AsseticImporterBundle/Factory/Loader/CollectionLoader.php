<?php

/**
 * Loads collected formulae.
 *
 * @author Andrey F. Mindubaev <covex.mobile@gmail.com>
 * @license http://opensource.org/licenses/MIT  MIT License
 */
namespace Apnet\AsseticImporterBundle\Factory\Loader;

use Assetic\Factory\Loader\FormulaLoaderInterface;
use Assetic\Factory\Resource\ResourceInterface;
use Apnet\AsseticImporterBundle\Factory\Resource\CollectionResourceInterface;

/**
 * Loads collected formulae.
 */
class CollectionLoader implements FormulaLoaderInterface
{

  /**
   * {@inheritdoc}
   */
  public function load(ResourceInterface $resource)
  {
    if ($resource instanceof CollectionResourceInterface) {
      $content = $resource->getContent();
    } else {
      $content = array();
    }
    return $content;
  }
}
