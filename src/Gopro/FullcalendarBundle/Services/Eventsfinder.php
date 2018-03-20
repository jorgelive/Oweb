<?php

namespace Gopro\FullcalendarBundle\Services;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Http\AccessMap;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class Eventsfinder
{
    protected $managerRegistry;
    protected $container;
    protected $calendars;
    protected $manager;
    protected $repository;
    protected $options;

    public function __construct(ManagerRegistry $managerRegistry, Container $container)
    {
        $this->container = $container;
        $this->calendars = $this->container->getParameter('calendars');
        $this->managerRegistry = $managerRegistry;
    }

    public function setCalendar($calendar){

        if(!array_key_exists($calendar, $this->calendars)){
            throw new HttpException(500, sprintf("El calendario %s no esta en los parametros de configuración.", $calendar));
        }
        $this->options['name'] = $this->calendars[$calendar]['entity'];
        $this->options['parameters'] = $this->calendars[$calendar]['parameters'];
        $this->options['repositorymethod'] = $this->calendars[$calendar]['repositorymethod'];
        $this->options['show'] = $this->calendars[$calendar]['show'];
        $this->options['edit'] = $this->calendars[$calendar]['edit'];

        $this->manager = $this->managerRegistry->getManagerForClass($this->options['name']);
        $this->repository = $this->manager->getRepository($this->options['name']);
    }

    public function getEvents($dataFrom, $dataTo) {

        if(!empty($this->options['repositorymethod'])){
            return $this->repository->{$this->options['repositorymethod']}($dataFrom, $dataTo);
        }else{
            $qb = $this->manager->createQueryBuilder()
                ->select('c')
                ->from($this->options['name'], 'c')
                ->where('c.'. $this->options['parameters']['start'] . ' BETWEEN :firstDate AND :lastDate')
                ->setParameter('firstDate', $dataFrom)
                ->setParameter('lastDate', $dataTo)
            ;
            return $qb->getQuery()->getResult();
        }

    }

    public function serialize($elements) {
        $result = [];

        if(true === $this->container->get('security.authorization_checker')->isGranted($this->options['show']['role'])){
            $i=0;
            foreach ($elements as $element) {
                foreach ($this->options['parameters'] as $key => $parameter){
                    if(strpos($parameter, '.') > 0){
                        $methods = explode('.', $parameter);
                    }else{
                        $methods = [$parameter];
                    }

                    $clonedElement = clone $element; //var_dump($element);
                    foreach ($methods as $method){
                        $methodFormated = 'get' . ucfirst($method);
                        $clonedElement = $clonedElement->$methodFormated();
                    }

                    if($key == 'start' || $key == 'end'){
                        $result[$i][$key] = $clonedElement->format("Y-m-d\TH:i:sP");
                    }elseif($key == 'url'){
                        if(true === $this->container->get('security.authorization_checker')->isGranted($this->options['edit']['role'])){
                            $result[$i][$key] = $this->container->get('router')->generate($this->options['edit']['route'], ['id' => $clonedElement]);
                        }else{
                            $result[$i][$key] = $this->container->get('router')->generate($this->options['show']['route'], ['id' => $clonedElement]);
                        }

                    }else{
                        $result[$i][$key] = $clonedElement;
                    }

                }
                $i++;
            }
        }
        return json_encode($result);
    }
}