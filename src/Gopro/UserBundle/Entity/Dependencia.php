<?php

namespace Gopro\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Dependencia
 *
 * @ORM\Table(name="use_dependencia")
 * @ORM\Entity
 */

class Dependencia
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $color;

    /**
     * @var \Gopro\UserBundle\Entity\Organizacion
     *
     * @ORM\ManyToOne(targetEntity="Organizacion", inversedBy="dependencias")
     */
    protected $organizacion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="dependencia", cascade={"persist","remove"}, orphanRemoval=true)
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function getOrganizaciondependencia()
    {
        if(is_null($this->getNombre())) {
            $nombre = sprintf("Id: %s.", $this->getId());
        }else{
            $nombre = $this->getNombre();
        }

        if(!is_null($this->getOrganizacion())){
            $organizacion = $this->getOrganizacion()->getNombre();
            if(empty($organizacion)){
                $organizacion = sprintf("Id: %s.", $this->getOrganizacion()->getId());
            }
        }else{
            $organizacion = 'No asignado no asignado';
        }

        return sprintf("%s - %s", $organizacion, $nombre);
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
     * Set nombre
     *
     * @param string $nombre
     * @return Dependencia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Dependencia
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Dependencia
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set organizacion
     *
     * @param \Gopro\UserBundle\Entity\Organizacion $organizacion
     * @return Dependencia
     */
    public function setOrganizacion(\Gopro\UserBundle\Entity\Organizacion $organizacion = null)
    {
        $this->organizacion = $organizacion;

        return $this;
    }

    /**
     * Get organizacion
     *
     * @return \Gopro\UserBundle\Entity\Organizacion 
     */
    public function getOrganizacion()
    {
        return $this->organizacion;
    }

    /**
     * Add users
     *
     * @param \Gopro\UserBundle\Entity\User $user
     * @return Dependencia
     */
    public function addUser(\Gopro\UserBundle\Entity\User $user)
    {
        $user->setDependencia($this);

        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Gopro\UserBundle\Entity\User $user
     */
    public function removeUser(\Gopro\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getOrganizaciondependencia();
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Dependencia
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
