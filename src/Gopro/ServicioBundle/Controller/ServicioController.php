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
 * @Route("/servicio")
 */
class ServicioController extends Controller
{

    /**
     * @Route("/alldropdown", name="gopro_servicio_servicio_alldropdown")
     */
    public function alldropdownAction(Request $request)
    {
        $servicios = $this->getDoctrine()
            ->getRepository('GoproServicioBundle:Servicio')->createQueryBuilder('s');

        if(!empty($request->get('q'))){
            $servicios->where('s.nombre like :cadena')
                ->setParameter('cadena', '%' . $request->get('q') . '%');
        }

        $servicios->orderBy('s.nombre', 'ASC');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $servicios->getQuery(),
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

        $content = [
            'status' => 'OK',
            'more' => ($maxItems < $totalItems),
            'items' => $resultado
        ];
        $status = Response::HTTP_OK;

        return $this->makeresponse($content, $status);
    }


    /**
     * @Route("/ajaxinfo/{id}", name="gopro_servicio_servicio_ajaxinfo", defaults={"id"=null})
     */
    public function ajaxinfoAction(Request $request, $id)
    {

        $servicio=$this->getDoctrine()
            ->getRepository('GoproServicioBundle:Servicio')
            ->find($id);

        if(!$servicio){
            $content = [];
            $status = Response::HTTP_NO_CONTENT;
            return $this->makeresponse($content, $status);
        }

        $content['id'] = $servicio->getId();
        $content['paralelo'] = $servicio->getParalelo();

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
