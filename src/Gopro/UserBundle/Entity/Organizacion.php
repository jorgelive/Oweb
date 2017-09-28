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
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $razonsocial;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=11, unique=true)
     */
    private $numerodocumento;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=200)
     */
    private $direccion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Dependencia", mappedBy="organizacion", cascade={"persist","remove"}, orphanRemoval=true)
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
     * Set numerodocumento
     *
     * @param string $numerodocumento
     * @return Organizacion
     */
    public function setNumerodocumento($numerodocumento)
    {
        $this->numerodocumento = $numerodocumento;

        return $this;
    }

    /**
     * Get numerodocumento
     *
     * @return string 
     */
    public function getNumerodocumento()
    {
        return $this->numerodocumento;
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
     * @param \Gopro\UserBundle\Entity\Dependencia $dependencia
     * @return Organizacion
     */
    public function addDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencia)
    {
        $dependencia->setOrganizacion($this);

        $this->dependencias[] = $dependencia;

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
     * @param \Gopro\UserBundle\Entity\Dependencia $dependencia
     */
    public function removeDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencia)
    {
        $this->dependencias->removeElement($dependencia);
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

    /**
     * @return string
     */
    function __toString()
    {
        if(is_null($this->getNombre())) {
            return 'NULL';
        }

        return $this->getNombre();
    }

    /**
     * Set razonsocial
     *
     * @param string $razonsocial
     *
     * @return Organizacion
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }
}
