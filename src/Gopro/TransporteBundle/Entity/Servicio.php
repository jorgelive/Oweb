<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="tra_servicio")
 * @ORM\Entity
 */
class Servicio
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\UserBundle\Entity\Dependencia
     *
     * @ORM\ManyToOne(targetEntity="Gopro\UserBundle\Entity\Dependencia")
     */
    protected $dependencia;

    /**
     * @var \Gopro\TransporteBundle\Entity\Unidad
     *
     * @ORM\ManyToOne(targetEntity="Unidad", inversedBy="servicios")
     */
    protected $unidad;

    /**
     * @var \Gopro\TransporteBundle\Entity\Conductor
     *
     * @ORM\ManyToOne(targetEntity="Conductor", inversedBy="servicios")
     */
    protected $conductor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciocontable", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciocontables;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\Column(type="date", length=100)
     */
    private $fecha;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciofile", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciofiles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciooperativo", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciooperativos;

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

    public function __construct() {
        $this->serviciofiles = new ArrayCollection();
        $this->serviciocontables = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(is_null($this->getNombre())) {
            return 'NULL';
        }

        return $this->getNombre();
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
     * @return Servicio
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return Servicio
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Servicio
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Servicio
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
     * @return Servicio
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
     * Set dependencia
     *
     * @param \Gopro\UserBundle\Entity\Dependencia $dependencia
     *
     * @return Servicio
     */
    public function setDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencia = null)
    {
        $this->dependencia = $dependencia;

        return $this;
    }

    /**
     * Get dependencia
     *
     * @return \Gopro\UserBundle\Entity\Dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * Set unidad
     *
     * @param \Gopro\TransporteBundle\Entity\Unidad $unidad
     *
     * @return Servicio
     */
    public function setUnidad(\Gopro\TransporteBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \Gopro\TransporteBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set conductor
     *
     * @param \Gopro\TransporteBundle\Entity\Conductor $conductor
     *
     * @return Servicio
     */
    public function setConductor(\Gopro\TransporteBundle\Entity\Conductor $conductor = null)
    {
        $this->conductor = $conductor;

        return $this;
    }

    /**
     * Get conductor
     *
     * @return \Gopro\TransporteBundle\Entity\Conductor
     */
    public function getConductor()
    {
        return $this->conductor;
    }

    /**
     * Add serviciofile
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciofile $serviciofile
     *
     * @return Servicio
     */
    public function addServiciofile(\Gopro\TransporteBundle\Entity\Serviciofile $serviciofile)
    {
        $serviciofile->setServicio($this);

        $this->serviciofiles[] = $serviciofile;

        return $this;
    }

    /**
     * Remove serviciofile
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciofile $serviciofile
     */
    public function removeServiciofile(\Gopro\TransporteBundle\Entity\Serviciofile $serviciofile)
    {
        $this->serviciofiles->removeElement($serviciofile);
    }

    /**
     * Get serviciofiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciofiles()
    {
        return $this->serviciofiles;
    }

    /**
     * Add serviciocontable
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     *
     * @return Servicio
     */
    public function addServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable)
    {
        $serviciocontable->setServicio($this);

        $this->serviciocontables[] = $serviciocontable;

        return $this;
    }

    /**
     * Remove serviciocontable
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     */
    public function removeServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable)
    {
        $this->serviciocontables->removeElement($serviciocontable);
    }

    /**
     * Get serviciocontables
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciocontables()
    {
        return $this->serviciocontables;
    }

    /**
     * Add serviciooperativo
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo
     *
     * @return Servicio
     */
    public function addServiciooperativo(\Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo)
    {
        $serviciooperativo->setServicio($this);

        $this->serviciooperativos[] = $serviciooperativo;

        return $this;
    }

    /**
     * Remove serviciooperativo
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo
     */
    public function removeServiciooperativo(\Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo)
    {
        $this->serviciooperativos->removeElement($serviciooperativo);
    }

    /**
     * Get serviciooperativos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciooperativos()
    {
        return $this->serviciooperativos;
    }
}
