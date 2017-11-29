<?php

namespace Gopro\FullcalendarBundle\Services;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class Eventsfinder
{
    protected $managerRegistry;
    protected $container;
    protected $calendars;
    protected $manager;
    protected $parameters;
    protected $name;
    protected $repositorymethod;
    protected $repository;

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
        $this->name = $this->calendars[$calendar]['entity'];
        $this->parameters = $this->calendars[$calendar]['parameters'];
        $this->repositorymethod = $this->calendars[$calendar]['repositorymethod'];

        $this->manager = $this->managerRegistry->getManagerForClass($this->name);
        $this->repository = $this->manager->getRepository($this->name);
    }

    public function getEvents($dataFrom, $dataTo) {

        if(!empty($this->repositorymethod)){
            return $this->repository->{$this->repositorymethod}($dataFrom, $dataTo);
        }else{
            $qb = $this->manager->createQueryBuilder()
                ->select('c')
                ->from($this->name, 'c')
                ->where('c.'. $this->parameters['start'] . ' BETWEEN :firstDate AND :lastDate')
                ->setParameter('firstDate', $dataFrom)
                ->setParameter('lastDate', $dataTo)
            ;
            return $qb->getQuery()->getResult();
        }

    }

    public function serialize($elements) {
        $result = [];
        $i=0;
        foreach ($elements as $element) {
            foreach ($this->parameters as $key => $parameter){
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
                    $result[$i][$key] = $this->container->get('router')->generate('admin_gopro_transporte_servicio_show', ['id' => $clonedElement]);
                }else{
                    $result[$i][$key] = $clonedElement;
                }

            }
            $i++;
        }
        return json_encode($result);
    }
}