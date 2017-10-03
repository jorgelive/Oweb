<?php

namespace Gopro\MainBundle\DependencyInjection;

use Gopro\MainBundle\Service\Variableproceso;

/**
 * Variableproceso trait.
 *
 */
trait VariableprocesoTrait
{
    /**
     * @var Variableproceso
     */
    protected $variableproceso;

    /**
     * Sets the variableproceso.
     *
     * @param Variableproceso|null $container A ContainerInterface instance or null
     */
    public function setVariableproceso(Variableproceso $variableproceso = null)
    {
        $this->variableproceso = $variableproceso;
    }
}
