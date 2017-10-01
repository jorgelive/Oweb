<?php

namespace Gopro\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'Vipac');
    }

    /**
     * @Route("/sidebar")
     * @Template()
     */
    public function sidebarAction()
    {
        $items=array(
            //array('nombre'=>'Generador de firmas','route'=>'gopro_vipac_extra_firma'),
            array('nombre'=>'Administrador','route'=>'sonata_admin_dashboard'),
            array('nombre'=>'Servicios','route'=>'admin_gopro_transporte_servicio_list'),
            array('nombre'=>'Cargador','route'=>'gopro_transporte_cargador_genericoprograma'),
        );
        return array('items'=> $items);
    }
}
