<?php

/**
 * Apnet Assetic Importer Bundle
 *
 * @author Andrey F. Mindubaev <covex.mobile@gmail.com>
 * @license http://opensource.org/licenses/MIT  MIT License
 */
namespace Apnet\AsseticWatcherBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Apnet Assetic Importer Bundle
 */
class ApnetAsseticWatcherBundle extends Bundle
{

  /**
   * {@inheritdoc}
   */
  public function build(ContainerBuilder $container)
  {
    $container->addCompilerPass(
      new DependencyInjection\Compiler\FactoryPass()
    );
    $container->addCompilerPass(
      new DependencyInjection\Compiler\SourceCodePass()
    );
  }
}
