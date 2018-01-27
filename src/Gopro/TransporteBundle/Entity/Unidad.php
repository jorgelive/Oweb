<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="tra_unidad")
 * @ORM\Entity
 */
class Unidad
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $placa;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $abreviatura;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $color;

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
     * @ORM\OneToMany(targetEntity="Servicio", mappedBy="unidad", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $servicios;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Unidadbitacora", mappedBy="unidad", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $unidadbitacoras;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre() ?? sprintf("Id: %s.", $this->getId()) ?? '';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->servicios = new ArrayCollection();
        $this->unidadbitacoras = new ArrayCollection();
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
     *
     * @return Unidad
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
     * Set placa
     *
     * @param string $placa
     *
     * @return Unidad
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Unidad
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
     * @return Unidad
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
     * @return Unidad
     */
    public function addServicio(\Gopro\TransporteBundle\Entity\Servicio $servicio)
    {
        $servicio->setUnidad($this);

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
     * @return Unidad
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
     * Set color
     *
     * @param string $color
     *
     * @return Unidad
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

    /**
     * Add unidadbitacora.
     *
     * @param \Gopro\TransporteBundle\Entity\Unidadbitacora $unidadbitacora
     *
     * @return Unidad
     */
    public function addUnidadbitacora(\Gopro\TransporteBundle\Entity\Unidadbitacora $unidadbitacora)
    {
        $unidadbitacora->setUnidad($this);

        $this->unidadbitacoras[] = $unidadbitacora;
    
        return $this;
    }

    /**
     * Remove unidadbitacora.
     *
     * @param \Gopro\TransporteBundle\Entity\Unidadbitacora $unidadbitacora
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUnidadbitacora(\Gopro\TransporteBundle\Entity\Unidadbitacora $unidadbitacora)
    {
        return $this->unidadbitacoras->removeElement($unidadbitacora);
    }

    /**
     * Get unidadbitacoras.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnidadbitacoras()
    {
        return $this->unidadbitacoras;
    }
}
