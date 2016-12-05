<?php

namespace Jmleroux\JmlShopping\Api;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Jmleroux\JmlShopping\Api\ApiBundle\ApiBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class MicroKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new SecurityBundle(),
            new ApiBundle(),
        ];

        return $bundles;
    }

    public function getRootDir()
    {
        return dirname(__DIR__);
    }

    public function getCacheDir()
    {
        return $this->getRootDir() . '/var/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return $this->getRootDir() . '/var/logs';
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->mount('/', $routes->import($this->getRootDir() . '/app/config/routing.yml'));
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/app/config/config_' . $this->getEnvironment() . '.yml');
    }
}
