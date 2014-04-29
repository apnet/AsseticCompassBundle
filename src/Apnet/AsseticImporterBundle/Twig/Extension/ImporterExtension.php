<?php

namespace Apnet\AsseticImporterBundle\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Apnet\AsseticImporterBundle\Factory\Resource\CollectionResourceInterface;
use Symfony\Bundle\TwigBundle\Extension\AssetsExtension;

class ImporterExtension extends \Twig_Extension
{

  /**
   * @var bool
   */
  private $useController;

  /**
   * @var Router
   */
  private $router;

  /**
   * @var CollectionResourceInterface
   */
  private $res;

  /**
   * @var AssetsExtension
   */
  private $assets;

  /**
   * Public constructor
   *
   * @param bool $useController Use controller
   */
  public function __construct($useController)
  {
    $this->useController = $useController;
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions()
  {
    return array(
      new \Twig_SimpleFunction('imported_asset', array($this, 'importedAsset')),
    );
  }

  /**
   * Return absolute path to imported asset
   *
   * @param string $path       Target import path
   * @param array  $parameters Parameters
   *
   * @return string
   */
  public function importedAsset($path, $parameters = array())
  {
    if ($this->useController) {
      $path = $this->router->generate(
        "_assetic_" . $this->res->getFormulaeName($path),
        $parameters
      );
    } else {
      $path = $this->assets->getAssetUrl(
        ltrim($path, "/")
      );
    }

    return $path;
  }

  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'apnet_importer_extension';
  }

  /**
   * Set router
   *
   * @param Router $router Router
   *
   * @return null
   */
  public function setRouter(Router $router)
  {
    $this->router = $router;
  }

  /**
   * Set collection resource
   *
   * @param CollectionResourceInterface $res Collection resource
   *
   * @return null
   */
  public function setCollectionResource(CollectionResourceInterface $res)
  {
    $this->res = $res;
  }

  /**
   * Set TwigBundle AssetsExtension
   *
   * @param AssetsExtension $assetsExtension Assets extension
   *
   * @return null
   */
  public function setAssetsExtension(AssetsExtension $assetsExtension)
  {
    $this->assets = $assetsExtension;
  }
}
