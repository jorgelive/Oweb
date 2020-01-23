<?php

namespace Gopro\FitBundle\Controller;

use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Alimento controller.
 *
 * @Route("/alimento")
 */
class AlimentoController extends Controller
{

    /**
     * @Route("/ajaxinfo/{id}", name="gopro_fit_alimento_ajaxinfo", defaults={"id"=null})
     */
    public function ajaxinfoAction(Request $request, $id)
    {

        $alimento = $this->getDoctrine()
            ->getRepository('GoproFitBundle:Alimento')
            ->find($id);

        if(!$alimento){
            $content = [];
            $status = Response::HTTP_NO_CONTENT;
            return $this->makeresponse($content, $status);
        }

        $content['id'] = $alimento->getId();
        $content['grasa'] = $alimento->getGrasa();
        $content['carbohidrato'] = $alimento->getCarbohidrato();
        $content['proteina'] = $alimento->getProteina();
        $content['medidaalimento'] = $alimento->getMedidaalimento() ? $alimento->getMedidaalimento()->getNombre() : null;
        $content['cantidad'] = $alimento->getCantidad();
        $content['proteinaaltovalor'] = $alimento->getProteinaaltovalor();
        $content['tipoalimento'] = $alimento->getTipoalimento() ? $alimento->getTipoalimento()->getNombre() : null;

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
