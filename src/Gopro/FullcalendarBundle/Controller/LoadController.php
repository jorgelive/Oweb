<?php

namespace Gopro\FullcalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Cargador controller.
 *
 * @Route("/load")
 */
class LoadController extends Controller
{
    private $manager;

    /**
     * @Route("/event/{calendar}",  name="gopro_fullcalendar_load_event")
     */
    function eventAction(Request $request, $calendar) {

        $data = [];
        $data['from'] = new \DateTime($request->get('start'));
        $data['to'] = new \DateTime($request->get('end'));

        $eventsfinder = $this->get('gopro.fullcalendar.eventsfinder');
        $eventsfinder->setCalendar($calendar);

        $events = $eventsfinder->getEvents($data);
        $status = empty($events) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $jsonContent = $eventsfinder->serialize($events);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($jsonContent);
        $response->setStatusCode($status);
        return $response;
    }

    /**
     * @Route("/resource/{calendar}",  name="gopro_fullcalendar_load_resource")
     */
    function resourceAction(Request $request, $calendar) {

        $data = [];
        $data['from'] = new \DateTime($request->get('start'));
        $data['to'] = new \DateTime($request->get('end'));

        $eventsfinder = $this->get('gopro.fullcalendar.eventsfinder');
        $eventsfinder->setCalendar($calendar);

        $events = $eventsfinder->getEvents($data);
        $status = empty($events) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        $jsonContent = $eventsfinder->serializeResources($events);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($jsonContent);
        $response->setStatusCode($status);

        return $response;
    }


}