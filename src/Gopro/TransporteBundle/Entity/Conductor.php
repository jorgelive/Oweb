<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tra_conductor")
 * @ORM\Entity
 */
class Conductor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $licencia;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $abreviatura;

    /**
     * @var \DateTime $creado
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creado;

    /**
     * @var \DateTime $modificado
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $modificado;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Servicio", mappedBy="conductor", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $servicios;


    /**
     * @var \Gopro\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="Gopro\UserBundle\Entity\User", inversedBy="conductor")
     */
    private $user;

    /**
     * @return string
     */
    public function __toString()
    {
        if(is_null($this->getUser()) || is_null($this->getUser()->getFullname())) {
            return sprintf("Id: %s.", $this->getId());
        }

        return sprintf("%s", $this->getUser()->getFullname());
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->servicios = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set licencia
     *
     * @param string $licencia
     *
     * @return Conductor
     */
    public function setLicencia($licencia)
    {
        $this->licencia = $licencia;

        return $this;
    }

    /**
     * Get licencia
     *
     * @return string
     */
    public function getLicencia()
    {
        return $this->licencia;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Conductor
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set modificado
     *
     * @param \DateTime $modificado
     *
     * @return Conductor
     */
    public function setModificado($modificado)
    {
        $this->modificado = $modificado;

        return $this;
    }

    /**
     * Get modificado
     *
     * @return \DateTime
     */
    public function getModificado()
    {
        return $this->modificado;
    }

    /**
     * Add servicio
     *
     * @param \Gopro\TransporteBundle\Entity\Servicio $servicio
     *
     * @return Conductor
     */
    public function addServicio(\Gopro\TransporteBundle\Entity\Servicio $servicio)
    {
        $servicio->setConductor($this);

        $this->servicios[] = $servicio;

        return $this;
    }

    /**
     * Remove servicio
     *
     * @param \Gopro\TransporteBundle\Entity\Servicio $servicio
     */
    public function removeServicio(\Gopro\TransporteBundle\Entity\Servicio $servicio)
    {
        $this->servicios->removeElement($servicio);
    }

    /**
     * Get servicios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServicios()
    {
        return $this->servicios;
    }

    /**
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return Conductor
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set user
     *
     * @param \Gopro\UserBundle\Entity\User $user
     *
     * @return Conductor
     */
    public function setUser(\Gopro\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Gopro\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
