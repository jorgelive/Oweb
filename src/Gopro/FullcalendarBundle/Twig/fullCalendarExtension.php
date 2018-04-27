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
        $exists = $this->_router->getRouteCollection()->get('gopro_fullcalendar_load_event');
        if (null === $exists)
        {
            return null;
        }

        return $this->_router->generate('gopro_fullcalendar_load_event', ['calendar' => $calendar]);
    }

    public function generateResourceUrl($calendar){
        $exists = $this->_router->getRouteCollection()->get('gopro_fullcalendar_load_resource');
        if (null === $exists)
        {
            return null;
        }

        return $this->_router->generate('gopro_fullcalendar_load_resource', ['calendar' => $calendar]);
    }

    public function fullCalendar($calendars, $defaultView = null, $views = [], $allDaySlot = false)
    {
        if (empty($views)){
            $views = ['agendaDay', 'agendaTwoDays', 'agendaWeek', 'month', 'listMonth'];
        }

        if (empty($defaultView)){
            $defaultView = 'agendaWeek';
        }

        if (!is_array($calendars) && is_string($calendars)){
            $calendars = ['Default' => $calendars];
        }

        if(!is_array($views) && is_string($views)) {
            $views[] = $views;
        }

        $views = implode(', ', $views);

        foreach ($calendars as $key => $calendar){
            $calendarsUrls[] = ['nombre' => $key,
                'event' => $this->generateUrl($calendar),
                'resource' =>  $this->generateResourceUrl($calendar)
                ];
        }

        $arrayKeys = array_keys($calendarsUrls);
        $defaultLabel = $calendarsUrls[$arrayKeys[0]]['nombre'];
        $defaultEventUrl = $calendarsUrls[$arrayKeys[0]]['event'];
        $defaultResourceUrl = $calendarsUrls[$arrayKeys[0]]['resource'];

        $calendarsUrls = json_encode($calendarsUrls);

        if($allDaySlot === true){
            $allDaySlot = 'true';
        }else{
            $allDaySlot = 'false';
        }

        $script = <<<JS
    $(document).ready(function() {
        
        var resourceUrl = '$defaultResourceUrl';
        
        var data = $calendarsUrls;

        var s = $("<select style=\"margin-top: 10px; margin-left: 10px;\" id=\"calendarSelector\" />");
        
        s.change(function() {
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource', data[s.val()]['event'] )
            resourceUrl = data[s.val()]['resource'];
            $('#calendar').fullCalendar('option','resourceLabelText',data[s.val()]['nombre']);
        })
        
        for(var val in data) {
            $("<option />", {text: data[val]['nombre'], value: val}).appendTo(s);
        }
        $("#calendar").before(s);
        
        function getResources(start, end, timezone, handleData) {
            var params = { start: start.format("YYYY-MM-DD"), end: end.format("YYYY-MM-DD") };
            var strParams = jQuery.param( params );
            
            $.ajax({
                url: resourceUrl + '?' + strParams,
                success:function(data) {
                    handleData(data);
                }
            });
        }
        
        $('#calendar').fullCalendar({
            resourceAreaWidth: 100,
            aspectRatio: 1,
            scrollTime: '00:00',
            header: {
                left: 'promptResource today prev,next',
                center: 'title',
                right: '$views'
            },
            defaultView: '$defaultView',
            refetchResourcesOnNavigate: true,
            views: {
                timelineThreeDays: {
                    type: 'timeline',
                    duration: { days: 3 }
                },
                agendaTwoDays: {
                    type: 'agenda',
                    duration: { days: 2 },
                    groupByResource: true
                }
            },
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            resourceLabelText: '$defaultLabel',
            allDaySlot: $allDaySlot,
            locale: 'es',
            nowIndicator: true,
            navLinks: true,
            editable: false,
            eventLimit: true,
            resources: function(callback, start, end, timezone) {
                getResources(start, end, timezone, function(resourceObjects) {
                    callback(resourceObjects);
                });
            },
            events: '$defaultEventUrl'
        });
    });

JS;

        return "<script>" . $script . "</script><div class='box box-primary'><div id='calendar'></div></div>";
    }
}