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
        $this->options['entity'] = $this->calendars[$calendar]['entity'];
        $this->options['parameters'] = $this->calendars[$calendar]['parameters'];
        if(isset($this->calendars[$calendar]['resource'])) {
            $this->options['resource'] = $this->calendars[$calendar]['resource'];
        }
        if(isset($this->options['repositorymethod']) && isset($this->options['relatedproperty'])){
            throw new HttpException(500, 'Solo debe de haber uno de los dos parametros: repositorymethod o relatedproperty.');
        }

        if(isset($this->calendars[$calendar]['repositorymethod'])){
            $this->options['repositorymethod'] = $this->calendars[$calendar]['repositorymethod'];
        }
        if(isset($this->calendars[$calendar]['relatedproperty'])){
            $this->options['relatedproperty'] = $this->calendars[$calendar]['relatedproperty'];
        }

        $this->manager = $this->managerRegistry->getManagerForClass($this->options['entity']);
        $this->repository = $this->manager->getRepository($this->options['entity']);
    }

    public function getEvents($data) {

        if(isset($this->options['relatedproperty']) && !isset($data['relatedPropertyId'])){
            throw new HttpException(500, 'La propiedad relacionada debe estar especificada ya que existe en la configuración.');
        }

        if(!empty($this->options['repositorymethod'])){
            //Para consultas complejas
            $data['user'] = $this->container->get('security.token_storage')->getToken()->getUser();

            return $this->repository->{$this->options['repositorymethod']}($data);
        }else{
            //Para consultas simples
            $qb = $this->manager->createQueryBuilder()
                ->select('c')
                ->from($this->options['entity'], 'c')
                ->where('c.'. $this->options['parameters']['start'] . ' BETWEEN :firstDate AND :lastDate');

            if(isset($this->options['relatedproperty'])){
                $qb->andWhere('c.' . $this->options['relatedproperty'] . ' = :relatedproperty')
                    ->setParameter('relatedproperty', $data['relatePropertyId']);            }

            $qb->setParameter('firstDate', $data['from'])
                ->setParameter('lastDate', $data['to'])
            ;
            return $qb->getQuery()->getResult();
        }

    }

    public function serializeResources($elements) {

        $result = [];
        $aux = [];
        if(isset($this->options['resource'])){
            $i=0;
            foreach ($elements as $element) {
                foreach ($this->options['resource'] as $key => $parameter){
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

                    if($key == 'id'){
                        if(false !== array_search($clonedElement, $aux, true)){
                            unset($result[$i]);
                            $agregado = false;
                            break;
                        }else{
                            $aux[] = $clonedElement;
                            $agregado = true;
                        }
                    }
                    $result[$i][$key] = $clonedElement;
                }
                if($agregado === true){
                    $i++;
                }

            }

            usort($result, function($a, $b) {
                return $a['id'] <=> $b['id'];
            });
        }else{
            $result[] = ['id' => 'default', 'title' => 'Default'];
        }



        return json_encode($result);
    }

    public function serialize($elements) {

        $result = [];

        $i=0;
        foreach ($elements as $element) {
            foreach ($this->options['parameters'] as $key => $parameter){
                if($key == 'url'){ // el parametro url es array porceso el subparametro id
                    $subject = $parameter['id'];
                }else{
                    $subject = $parameter;
                }

                if(strpos($subject, '.') > 0){
                    $methods = explode('.', $subject);
                }else{
                    $methods = [$subject];
                }

                $copiedElement = $element; //ya no clono;
                foreach ($methods as $method){
                    $methodFormated = 'get' . ucfirst($method);
                    $copiedElement = $copiedElement->$methodFormated();
                }

                if($key == 'start' || $key == 'end'){
                    $result[$i][$key] = $copiedElement->format("Y-m-d\TH:i:sP");
                }elseif($key == 'url'){
                    if(isset($parameter['edit']) && true === $this->container->get('security.authorization_checker')->isGranted($parameter['edit']['role'])){
                        $result[$i]['url'] = $this->container->get('router')->generate($parameter['edit']['route'], ['id' => $copiedElement]);
                    }elseif(isset($parameter['show']) && true === $this->container->get('security.authorization_checker')->isGranted($parameter['show']['role'])){
                        $result[$i]['url'] = $this->container->get('router')->generate($parameter['show']['route'], ['id' => $copiedElement]);
                    }
                }else{
                    $result[$i][$key] = $copiedElement;
                }

            }
            if($this->options['resource']){
                $copiedElement = $element; //ya no clono

                if(strpos($this->options['resource']['id'], '.') > 0){
                    $methods = explode('.', $this->options['resource']['id']);
                }else{
                    $methods = [$this->options['resource']['id']];
                }

                foreach ($methods as $method){
                    $methodFormated = 'get' . ucfirst($method);
                    $copiedElement = $copiedElement->$methodFormated();
                }

                $result[$i]['resourceId'] = $copiedElement;
            }else{
                $result[$i]['resourceId'] = 'default';
            }

            $i++;

        }
        return json_encode($result);
    }
}