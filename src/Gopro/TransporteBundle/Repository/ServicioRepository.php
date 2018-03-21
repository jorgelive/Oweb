<?php


namespace Gopro\TransporteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Gopro\UserBundle\Entity\User;

class ServicioRepository extends EntityRepository
{
    public function findCalendarConductorColored($dataFrom, $dataTo, User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('GoproTransporteBundle:Servicio', 's')
            ->where('s.fechahorainicio BETWEEN :firstDate AND :lastDate');

        if($user && $user->getDependencia() && $user->getDependencia()->getId() != 1){
            $qb->andWhere('s.dependencia = :dependencia')
                ->setParameter('dependencia', $user->getDependencia()->getId());
        }

        $qb->setParameter('firstDate', $dataFrom)
            ->setParameter('lastDate', $dataTo)
        ;

        return $qb->getQuery()->getResult();

    }


    public function findCalendarUnidadColored($dataFrom, $dataTo, User $user)
    {

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('GoproTransporteBundle:Servicio', 's')
            ->where('s.fechahorainicio BETWEEN :firstDate AND :lastDate');

        if($user && $user->getDependencia() && $user->getDependencia()->getId() != 1){
            $qb->andWhere('s.dependencia = :dependencia')
                ->setParameter('dependencia', $user->getDependencia()->getId());
        }

        $qb->setParameter('firstDate', $dataFrom)
            ->setParameter('lastDate', $dataTo)
        ;
        return $qb->getQuery()->getResult();
    }
}