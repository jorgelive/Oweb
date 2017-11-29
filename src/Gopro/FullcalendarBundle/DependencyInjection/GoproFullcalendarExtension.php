<?php


namespace Gopro\FullcalendarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class GoproFullcalendarExtension  extends Extension
{
    /*
     * Carreguem els serveis exclusius del bundle, ja que un bundle ha de ser independent als serveis de laplicació
     * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('calendars', $config['calendars']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}