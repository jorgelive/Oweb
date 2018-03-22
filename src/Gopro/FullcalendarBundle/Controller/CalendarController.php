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
 * @Route("/event")
 */
class CalendarController extends Controller
{
    private $manager;

    /**
     * @Route("/load/{calendar}", name="gopro_fullcalendar_event_load")
     */
    function loadAction(Request $request, $calendar) {

        $dataFrom = new \DateTime($request->get('start'));
        $dataTo = new \DateTime($request->get('end'));

        $eventsfinder = $this->get('gopro.fullcalendar.eventsfinder');
        $eventsfinder->setCalendar($calendar);

        $events = $eventsfinder->getEvents($dataFrom, $dataTo);
        $status = empty($events) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $jsonContent = $eventsfinder->serialize($events);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($jsonContent);
        $response->setStatusCode($status);
        return $response;
    }

    /**
     * @Route("/resourceload/{calendar}", name="gopro_fullcalendar_resource_load")
     */
    function resourceloadAction(Request $request, $calendar) {

        $dataFrom = new \DateTime($request->get('start'));
        $dataTo = new \DateTime($request->get('end'));

        $eventsfinder = $this->get('gopro.fullcalendar.eventsfinder');
        $eventsfinder->setCalendar($calendar);

        $events = $eventsfinder->getEvents($dataFrom, $dataTo);
        $status = empty($events) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $jsonContent = $eventsfinder->serialize($events);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($jsonContent);
        $response->setStatusCode($status);
        return $response;
    }


}