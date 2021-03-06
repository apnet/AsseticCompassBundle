<?php

/**
 * Listener for kernel.request event
 *
 * @author Andrey F. Mindubaev <covex.mobile@gmail.com>
 * @license http://opensource.org/licenses/MIT  MIT License
 */
namespace Apnet\AsseticWatcherBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Apnet\AsseticWatcherBundle\Factory\SourceCodeWatcher;

/**
 * Listener for kernel.request event
 */
class KernelRequestListener
{

  /**
   * @var SourceCodeWatcher
   */
  private $assetWatcher;

  /**
   * @var bool
   */
  private $debug;

  /**
   * Public constructor
   *
   * @param SourceCodeWatcher $assetWatcher Asset watcher
   * @param bool              $debug        Kernel debug
   */
  public function __construct(SourceCodeWatcher $assetWatcher, $debug)
  {
    $this->assetWatcher = $assetWatcher;
    $this->debug = $debug;
  }

  /**
   * Run asset watcher
   *
   * @param GetResponseEvent $event Event
   *
   * @return null
   */
  public function compile(GetResponseEvent $event)
  {
    if (!$this->debug) {
      return;
    }
    if (HttpKernelInterface::MASTER_REQUEST !==  $event->getRequestType()) {
      return;
    }
    $this->assetWatcher->compile();
  }
}
