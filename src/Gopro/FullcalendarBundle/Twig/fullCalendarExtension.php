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

    public function generateUrl($calendar){
        $exists = $this->_router->getRouteCollection()->get('gopro_fullcalendar_event_load');
        if (null === $exists)
        {
            return null;
        }

        return $this->_router->generate('gopro_fullcalendar_event_load', ['calendar' => $calendar]);
    }

    public function fullCalendar($calendars, $defaultView = 'agendaWeek', $allDaySlot = false)
    {

        if (!is_array($calendars)){
            $calendars = ['default' => $calendars];
        }

        foreach ($calendars as $key => $calendar){
            $calendarsurls[$key] = $this->generateUrl($calendar);
        }

        $arrayKeys = array_keys($calendarsurls);
        $defaultUrl = $calendarsurls[$arrayKeys[0]];
        $calendarsurls = json_encode($calendarsurls);

        $dropdown = <<<JS

        var data = $calendarsurls;
        var s = $("<select id=\"calendarSelector\" />");
        
        s.change(function() {
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource', s.val() )
        })
        
        for(var val in data) {
            $("<option />", {text: val, value: data[val]}).appendTo(s);
        }
        $("#calendar").before(s);
JS;
        
        if($allDaySlot === true){
            $allDaySlot = 'true';
        }else{
            $allDaySlot = 'false';
        }

        $script = <<<JS
    $(document).ready(function() {
        $dropdown;   
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
            events: '$defaultUrl',
            allDaySlot: $allDaySlot,
            locale: 'es',
            nowIndicator: true
        });
    });
    

JS;

        return "<script>" . $script . "</script><div id='calendar'></div>";
    }
}