<?php


namespace Gopro\TransporteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ServicioRepository extends EntityRepository
{
    public function findCalendarUnidadColored($dataFrom, $dataTo)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('GoproTransporteBundle:Servicio', 'c')
            ->where('c.fechahorainicio BETWEEN :firstDate AND :lastDate')
            ->setParameter('firstDate', $dataFrom)
            ->setParameter('lastDate', $dataTo)
        ;

        return $qb->getQuery()->getResult();

    }
}