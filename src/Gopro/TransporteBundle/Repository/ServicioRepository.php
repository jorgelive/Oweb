<?php


namespace Gopro\TransporteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Gopro\UserBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpException;

class ServicioRepository extends EntityRepository
{
    public function findCalendarConductorColored($data)
    {
/*        if (!$data['user'] instanceof User){
            throw new HttpException(500, 'El dato de usuario no es instancia de la clase GoproUserbundle:Entity:User.');
        }else{
            $user = $data['user'];
        }*/

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('me')
            ->from('GoproTransporteBundle:Servicio', 'me')
            ->where('me.fechahorainicio BETWEEN :firstDate AND :lastDate');

/*        if ($user && $user->getDependencia() && $user->getDependencia()->getId() != 1) {
            $qb->andWhere('me.dependencia = :dependencia')
                ->setParameter('dependencia', $user->getDependencia()->getId());
        }*/

        $qb->setParameter('firstDate', $data['from'])
            ->setParameter('lastDate', $data['to'])
        ;

        return $qb;

    }

    public function findCalendarClienteColored($data)
    {

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('me')
            ->from('GoproTransporteBundle:Servicio', 'me')
            ->where('me.fechahorainicio BETWEEN :firstDate AND :lastDate');

        $qb->setParameter('firstDate', $data['from'])
            ->setParameter('lastDate', $data['to'])
        ;

        return $qb;

    }


    public function findCalendarUnidadColored($data)
    {

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('me')
            ->from('GoproTransporteBundle:Servicio', 's')
            ->where('s.fechahorainicio BETWEEN :firstDate AND :lastDate');


        $qb->setParameter('firstDate', $data['from'])
            ->setParameter('lastDate', $data['to'])
        ;
        return $qb;
    }
}