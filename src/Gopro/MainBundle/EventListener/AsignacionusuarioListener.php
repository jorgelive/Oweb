<?php
namespace Gopro\MainBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Gopro\CuentaBundle\Entity\Movimiento;

class AsignacionusuarioListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Movimiento && !$entity->getUser()) {
            $entity->setUser($this->tokenStorage->getToken()->getUser());
        }
    }
}