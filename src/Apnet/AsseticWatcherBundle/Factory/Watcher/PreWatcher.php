<?php

/**
 * Source files watcher
 *
 * @author Andrey F. Mindubaev <covex.mobile@gmail.com>
 * @license http://opensource.org/licenses/MIT  MIT License
 */
namespace Apnet\AsseticWatcherBundle\Factory\Watcher;

use Apnet\AsseticImporterBundle\Parser\ParserInterface;
use Assetic\FilterManager;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;

/**
 * PreWatcher internal assets
 */
class PreWatcher implements WatcherInterface
{

  /**
   * @var ParserInterface
   */
  private $parser;

  /**
   * @var FilterManager
   */
  private $filterManager;

  /**
   * Public constructor
   *
   * @param ParserInterface $parser        Config parser
   * @param FilterManager   $filterManager Asset Factory
   */
  public function __construct(ParserInterface $parser, FilterManager $filterManager)
  {
    $this->parser = $parser;
    $this->filterManager = $filterManager;
  }

  /**
   * {@inheritdoc}
   */
  public function getChildren($configPath)
  {
    $children = array();
    foreach ($this->loadConfig($configPath) as $asset) {
      foreach ($asset["inputs"] as $file) {
        if (substr($file, 0, 1) !== "/") { // Unix style
          $file = dirname($configPath) . "/" . $file;
        }
        $children[] = $file;
      }
    }
    return $children;
  }

  /**
   * {@inheritdoc}
   */
  public function compile($configPath)
  {
    $sourceRoot = dirname($configPath);
    foreach ($this->loadConfig($configPath) as $asset) {
      if (!isset($asset["options"]["output"])) {
        continue;
      }

      $assets = array();
      foreach ($asset["inputs"] as $input) {
        $assets[] = new FileAsset($sourceRoot . "/" . $input);
      }

      $filters = array();
      foreach ($asset["filters"] as $filter) {
        $filters[] = $this->filterManager->get($filter);
      }
      $collection = new AssetCollection($assets, $filters);

      file_put_contents(
        $sourceRoot . "/" . $asset["options"]["output"],
        $collection->dump()
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getType()
  {
    return "pre";
  }

  /**
   * Load config
   *
   * @param string $configPath Path to .yml file
   *
   * @return array
   */
  protected function loadConfig($configPath)
  {
    return $this->parser->load($configPath);
  }
}
