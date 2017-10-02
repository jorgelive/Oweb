<?php

namespace Gopro\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Cargador controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="gopro_main")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'Visitante');
    }

    /**
     * @Route("/navigation")
     * @Template()
     */
    public function navigationAction()
    {
        $items=array(
            //array('nombre'=>'Generador de firmas','route'=>'gopro_vipac_extra_firma'),
            array('nombre'=>'Inicio','route'=>'gopro_main'),
            array('nombre'=>'Admin','route'=>'sonata_admin_dashboard'),
            array('nombre'=>'Servicios','route'=>'admin_gopro_transporte_servicio_list'),
            array('nombre'=>'Cargador','route'=>'gopro_transporte_cargador_genericoprograma'),
        );
        return array('items'=> $items);
    }
}
