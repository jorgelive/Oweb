<?php

namespace Gopro\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Organizacion
 *
 * @ORM\Table(name="use_organizacion")
 * @ORM\Entity
 */

class Organizacion
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $nombre;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=11, unique=true)
     */
    private $ruc;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=200)
     */
    private $direccion;

    /**
     * @ORM\OneToMany(targetEntity="Dependencia", mappedBy="organizacion", cascade={"persist"})
     */
    protected $dependencias;

    public function __construct()
    {
        $this->dependencias = new ArrayCollection();
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
     * @return Organizacion
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
     * Set ruc
     *
     * @param string $ruc
     * @return Organizacion
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * Get ruc
     *
     * @return string 
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Organizacion
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
     * @return Organizacion
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
     * Add dependencias
     *
     * @param \Gopro\UserBundle\Entity\Dependencia $dependencias
     * @return Organizacion
     */
    public function addDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencias)
    {
        $this->dependencias[] = $dependencias;

        return $this;
    }

    public function setDependencias($dependencias)
    {
        if (count($dependencias) > 0) {
            foreach ($dependencias as $dependencia) {
                $this->addDependencia($dependencia);
            }
        }
        return $this;
    }

    /**
     * Remove dependencias
     *
     * @param \Gopro\UserBundle\Entity\Dependencia $dependencias
     */
    public function removeDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencias)
    {
        $this->dependencias->removeElement($dependencias);
    }

    /**
     * Get dependencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDependencias()
    {
        return $this->dependencias;
    }

    function __toString()
    {
        return $this->getNombre();
    }
}
