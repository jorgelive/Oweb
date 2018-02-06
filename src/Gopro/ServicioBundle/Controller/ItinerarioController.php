<?php

namespace Gopro\ServicioBundle\Controller;

use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Cargador controller.
 *
 * @Route("/itinerario")
 */
class ItinerarioController extends Controller
{

    /**
     * @Route("/ajaxinfo/{id}", name="gopro_servicio_itinerario_ajaxinfo", defaults={"id"=null})
     */
    public function ajaxinfoAction(Request $request, $id)
    {
        //?q=&_per_page=10&_page=1&field=tarifa&_=1513629738031
        $itinerario=$this->getDoctrine()
            ->getRepository('GoproServicioBundle:Itinerario')
            ->find($id);

        if(!$itinerario){
            $content = [];
            $status = Response::HTTP_NO_CONTENT;
            return $this->makeresponse($content, $status);
        }

        $content['id'] = $itinerario->getId();
        $content['hora'] = $itinerario->getHora()->format('H:i');
        $content['duracion'] = $itinerario->getDuracion();
        $status = Response::HTTP_OK;

        return $this->makeresponse($content, $status);

    }


    /**
     * @Route("/porserviciodropdown/{servicio}", name="gopro_servicio_itinerario_porserviciodropdown", defaults={"servicio"=null})
     */
    public function porserviciodropdownAction(Request $request, $servicio)
    {
        //?q=&_per_page=10&_page=1&field=tarifa&_=1513629738031
        $itinerarios = $this->getDoctrine()
            ->getRepository('GoproServicioBundle:Itinerario')->createQueryBuilder('i');
        if($servicio != 0){
            $itinerarios->where('i.servicio = :servicio')
                ->setParameter('servicio', $servicio);
        }

        if(!empty($request->get('q'))){
            $itinerarios->andWhere('i.nombre like :cadena')
                ->setParameter('cadena', '%' . $request->get('q') . '%');
        }

        $itinerarios->orderBy('i.nombre', 'ASC');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $itinerarios->getQuery(),
            $request->get('_page'),
            $request->get('_per_page')
        );

        if(!$pagination->getItems()){
            $content = ['status' => 'OK', 'items' => [], 'more' => false, 'message' => 'No existe contenido.'];
            $status = Response::HTTP_OK;// Response::HTTP_NO_CONTENT;
            return $this->makeresponse($content, $status);
        };

        foreach ($pagination->getItems() as $key => $item):
            $resultado[$key]['id'] = $item->getId();
            $resultado[$key]['label'] = $item->getNombre();
        endforeach;

        $totalItems = $pagination->getTotalItemCount();
        $maxItems = $request->get('_page') * $request->get('_per_page');

        //throw $this->createAccessDeniedException('no tiene el permiso para ver el contenido!');
        // subject will be empty to avoid unnecessary database requests and keep autocomplete function fast

        $content = [
            'status' => 'OK',
            'more' => ($maxItems < $totalItems),
            'items' => $resultado
        ];
        $status = Response::HTTP_OK;

        return $this->makeresponse($content, $status);
    }

    function makeresponse($content, $status){
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($content));
        $response->setStatusCode($status);
        return $response;

    }

}
