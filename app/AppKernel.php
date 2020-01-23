<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(), //requerido por full calendar
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\UserBundle\SonataUserBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\TranslationBundle\SonataTranslationBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(), //requerido por translationbundle
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Fkr\CssURLRewriteBundle\FkrCssURLRewriteBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(), //requerido por paginacion de ajaxdropdown
            new Exporter\Bridge\Symfony\Bundle\SonataExporterBundle(), //exportador separado
            new Gopro\UserBundle\GoproUserBundle(),
            new Gopro\ExcelBundle\GoproExcelBundle(),
            new Gopro\MainBundle\GoproMainBundle(),
            new Gopro\SonataBundle\GoproSonataBundle(),
            new Gopro\MaestroBundle\GoproMaestroBundle(),
            new Gopro\TransporteBundle\GoproTransporteBundle(),
            new Gopro\FullcalendarBundle\GoproFullcalendarBundle(),
            new Gopro\CotizacionBundle\GoproCotizacionBundle(),
            new Gopro\ServicioBundle\GoproServicioBundle(),
            new Gopro\FitBundle\GoproFitBundle(),
            new Gopro\CuentaBundle\GoproCuentaBundle(),
            new Gopro\ComprobanteBundle\GoproComprobanteBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
