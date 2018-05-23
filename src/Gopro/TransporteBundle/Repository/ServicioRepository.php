<?php


namespace Gopro\TransporteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Gopro\UserBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpException;

class ServicioRepository extends EntityRepository
{
    public function findCalendarConductorColored($data)
    {
        if (!$data['user'] instanceof User){
            throw new HttpException(500, 'El dato de usuario no es instancia de la clase GoproUserbundle:Entity:User.');
        }else{
            $user = $data['user'];
        }

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('GoproTransporteBundle:Servicio', 's')
            ->where('s.fechahorainicio BETWEEN :firstDate AND :lastDate');

        if($user && $user->getDependencia() && $user->getDependencia()->getId() != 1){
            $qb->andWhere('s.dependencia = :dependencia')
                ->setParameter('dependencia', $user->getDependencia()->getId());
        }

        $qb->setParameter('firstDate', $data['from'])
            ->setParameter('lastDate', $data['to'])
        ;

        return $qb->getQuery()->getResult();

    }

    public function findCalendarClienteColored($data)
    {
        if (!$data['user'] instanceof User){
            throw new HttpException(500, 'El dato de usuario no es instancia de la clase GoproUserbundle:Entity:User.');
        }else{
            $user = $data['user'];
        }

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('GoproTransporteBundle:Servicio', 's')
            ->where('s.fechahorainicio BETWEEN :firstDate AND :lastDate');

        if($user && $user->getDependencia() && $user->getDependencia()->getId() != 1){
            $qb->andWhere('s.dependencia = :dependencia')
                ->setParameter('dependencia', $user->getDependencia()->getId());
        }

        $qb->setParameter('firstDate', $data['from'])
            ->setParameter('lastDate', $data['to'])
        ;

        return $qb->getQuery()->getResult();

    }


    public function findCalendarUnidadColored($data)
    {

        if (!$data['user'] instanceof User){
            throw new HttpException(500, 'El dato de usuario no es instancia de la clase GoproUserbundle:Entity:User.');
        }else{
            $user = $data['user'];
        }


        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('GoproTransporteBundle:Servicio', 's')
            ->where('s.fechahorainicio BETWEEN :firstDate AND :lastDate');

        if($user && $user->getDependencia() && $user->getDependencia()->getId() != 1){
            $qb->andWhere('s.dependencia = :dependencia')
                ->setParameter('dependencia', $user->getDependencia()->getId());
        }

        $qb->setParameter('firstDate', $data['from'])
            ->setParameter('lastDate', $data['to'])
        ;
        return $qb->getQuery()->getResult();
    }
}