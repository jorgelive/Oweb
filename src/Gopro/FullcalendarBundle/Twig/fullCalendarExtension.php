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

    public function generateResourceUrl($calendar){
        $exists = $this->_router->getRouteCollection()->get('gopro_fullcalendar_resource_load');
        if (null === $exists)
        {
            return null;
        }

        return $this->_router->generate('gopro_fullcalendar_resource_load', ['calendar' => $calendar]);
    }

    public function fullCalendar($calendars, $defaultView = 'agendaWeek', $allDaySlot = false)
    {

        if (!is_array($calendars)){
            $calendars = ['Default' => $calendars];
        }

        foreach ($calendars as $key => $calendar){
            $calendarsUrls[] = ['nombre' => $key,
                'event' => $this->generateUrl($calendar),
                'resource' =>  $this->generateResourceUrl($calendar)
                ];
        }

        $arrayKeys = array_keys($calendarsUrls);
        $defaultEventUrl = $calendarsUrls[$arrayKeys[0]]['event'];
        $defaultResourceUrl = $calendarsUrls[$arrayKeys[0]]['resource'];

        $calendarsUrls = json_encode($calendarsUrls);

        if($allDaySlot === true){
            $allDaySlot = 'true';
        }else{
            $allDaySlot = 'false';
        }

        $old = <<<JS
    $(document).ready(function() {

        var resourceUrl = '$defaultResourceUrl';
        
        var data = $calendarsUrls;

        var s = $("<select style=\"margin-top: 10px; margin-left: 10px;\" id=\"calendarSelector\" />");
        
        s.change(function() {
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource', data[s.val()]['event'] )
            resourceUrl = data[s.val()]['resources'];
        })
        
        for(var val in data) {
            $("<option />", {text: data[val]['nombre'], value: val}).appendTo(s);
        }
        $("#calendar").before(s);
        
        function getResources(handleData) {
            $.ajax({
                url: resourceUrl,
                success:function(data) {
                    handleData(data);
                }
            });
        }
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'timelineDay,timelineThreeDays,month,agendaWeek,agendaDay,listMonth'
            },
            views: {
                timelineThreeDays: {
                    type: 'timeline',
                    duration: { days: 3 }
                }
            },
            resourceLabelText: 'Rooms',
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            defaultView: '$defaultView',
            navLinks: true,
            editable: false,
            eventLimit: true,
            events: '$defaultEventUrl',
            resources: function(callback) {
                getResources(function(resourceObjects) {
                    callback(resourceObjects);
                });
            },
            allDaySlot: $allDaySlot,
            locale: 'es',
            nowIndicator: true
        });
    });

JS;

        $script = <<<JS
    $(document).ready(function() {
        
        var resourceUrl = '$defaultResourceUrl';
        
        var data = $calendarsUrls;

        var s = $("<select style=\"margin-top: 10px; margin-left: 10px;\" id=\"calendarSelector\" />");
        
        s.change(function() {
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource', data[s.val()]['event'] )
            resourceUrl = data[s.val()]['resources'];
        })
        
        for(var val in data) {
            $("<option />", {text: data[val]['nombre'], value: val}).appendTo(s);
        }
        $("#calendar").before(s);
        
        $('#calendar').fullCalendar({
            resourceAreaWidth: 100,
            aspectRatio: 1.5,
            scrollTime: '00:00',
            header: {
              left: 'promptResource today prev,next',
              center: 'title',
              right: 'timelineDay, timelineThreeDays, agendaWeek, listMonth'
            },
            defaultView: '$defaultView',
            views: {
              timelineThreeDays: {
                type: 'timeline',
                duration: { days: 3 }
              }
            },
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            resourceLabelText: 'Unidades',
            allDaySlot: $allDaySlot,
            locale: 'es',
            nowIndicator: true,
            navLinks: true,
            editable: false,
            eventLimit: true,
            resources: [
              { id: 'a', title: 'Op1' },
              { id: 'b', title: 'Op2' },
              { id: 'c', title: 'Op3' }
        
            ],
            events: '$defaultEventUrl'
        });
    });

JS;

        return "<script>" . $script . "</script><div class='box box-primary'><div id='calendar'></div></div>";
    }
}