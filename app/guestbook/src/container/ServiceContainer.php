<?php
declare(strict_types=1);

namespace Piv\Guestbook\Src\Container;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Piv\Guestbook\Config\Config;

class ServiceContainer
{
    protected $containerBuilder;

    public function __construct()
    {
        $this->containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator(Config::DIR_CONFIG));
        $loader->load('services.yaml');
    }

    public function get()
    {
        return $this->containerBuilder;
    }
}
