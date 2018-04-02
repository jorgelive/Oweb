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
        return array('name' => is_null($this->getUser()) ? 'Visitante' : $this->getUser()->getFullName());
    }

    /**
     * @Route("/navigation")
     * @Template()
     */
    public function navigationAction()
    {
        $menu[] = [ 'nombre' => 'Transportes', 'items' => [

            ['nombre'=>'Servicios', 'route'=>'admin_gopro_transporte_servicio_list']
        ]
        ];

        $menu[] = [ 'nombre' => 'Reservas', 'items' => [
            ['nombre' => 'Files', 'route' => 'admin_gopro_cotizacion_file_list'],
            ['nombre' => 'Cotizaciones', 'route' => 'admin_gopro_cotizacion_cotizacion_list'],
        ]
        ];

        $menu[] = [ 'nombre' => 'Administrador', 'items' => [

            ['nombre' => 'Admin', 'route' => 'sonata_admin_dashboard'],
            ['nombre' => 'Registro de transacciones', 'route' => 'admin_gopro_cuenta_periodo_list'],
            ['nombre' => 'Cargador', 'route' => 'gopro_transporte_cargador_genericoprograma'],
        ]
        ];
        return array('menu'=> $menu);
    }
}
