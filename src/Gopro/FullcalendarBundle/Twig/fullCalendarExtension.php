<?php

namespace Gopro\FullcalendarBundle\Twig;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class fullCalendarExtension extends \Twig_Extension
{

    private $_router;

    public function __construct(Router $router)
    {
        $this->_router = $router;
    }

    public function getName() {
        return 'fullCalendar';
    }

    public function getFunctions()
    {

        return array(
            'fullCalendar' => new \Twig_SimpleFunction(
                'fullCalendar',
                array($this, 'fullCalendar'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function fullCalendar($calendar, $defaultView = 'agendaWeek', $allDaySlot = false)
    {
        $exists = $this->_router->getRouteCollection()->get('gopro_fullcalendar_event_load');
        if (null !== $exists)
        {
            $url = $this->_router->generate('gopro_fullcalendar_event_load', ['calendar' => $calendar]);
        }

        if($allDaySlot === true){
            $allDaySlot = 'true';
        }else{
            $allDaySlot = 'false';
        }

        $script = <<<EOT

<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            defaultView: '$defaultView',
            navLinks: true,
            editable: false,
            eventLimit: true,
            events: '$url',
            allDaySlot: $allDaySlot,
            locale: 'es'
        });
    });

    </script>
    <div id='calendar'></div>
EOT;



        return $script;
    }
}