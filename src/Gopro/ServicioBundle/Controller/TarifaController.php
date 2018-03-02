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
 * @Route("/tarifa")
 */
class TarifaController extends Controller
{

    /**
     * @Route("/ajaxinfo/{id}", name="gopro_servicio_tarifa_ajaxinfo", defaults={"id"=null})
     */
    public function ajaxinfoAction(Request $request, $id)
    {

        $tarifa = $this->getDoctrine()
            ->getRepository('GoproServicioBundle:Tarifa')
            ->find($id);

        if(!$tarifa){
            $content = [];
            $status = Response::HTTP_NO_CONTENT;
            return $this->makeresponse($content, $status);
        }

        $content['id'] = $tarifa->getId();
        $content['moneda'] = $tarifa->getMoneda() ? $tarifa->getMoneda()->getId() : null;
        $content['monto'] = $tarifa->getMonto();
        $content['prorrateado'] = $tarifa->getProrrateado();
        $content['capacidadmin'] = $tarifa->getCapacidadmin();
        $content['capacidadmax'] = $tarifa->getCapacidadmax();
        $content['tipotarifa'] = $tarifa->getTipotarifa()->getId();

        $status = Response::HTTP_OK;

        return $this->makeresponse($content, $status);

    }

    /**
     * @Route("/porcomponentedropdown/{componente}", name="gopro_servicio_tarifa_porcomponentedropdown", defaults={"componente"=null})
     */
    public function porcomponentedropdownAction(Request $request, $componente)
    {
        $tarifas = $this->getDoctrine()
            ->getRepository('GoproServicioBundle:Tarifa')->createQueryBuilder('t');
        if($componente != 0){
            $tarifas->where('t.componente = :componente')
                ->setParameter('componente', $componente);
        }

        if(!empty($request->get('q'))){
            $tarifas->andWhere('t.nombre like :cadena')
                ->setParameter('cadena', '%' . $request->get('q') . '%');
        }

        $tarifas->orderBy('t.nombre', 'ASC');
            //->orderBy('p.price', 'ASC')
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $tarifas->getQuery(),
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
            $resultado[$key]['label'] = $item->__toString();
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
