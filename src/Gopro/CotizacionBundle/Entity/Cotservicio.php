<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cotservicio
 *
 * @ORM\Table(name="cot_cotservicio")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\CotservicioRepository")
 */
class Cotservicio
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahorainicio", type="datetime")
     */
    private $fechahorainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahorafin", type="datetime", nullable=true)
     */
    private $fechahorafin;

    /**
     * @var \Gopro\CotizacionBundle\Entity\Cotizacion
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\Cotizacion", inversedBy="cotservicios")
     * @ORM\JoinColumn(name="cotizacion_id", referencedColumnName="id", nullable=false)
     */
    protected $cotizacion;

    /**
     * @var \Gopro\ServicioBundle\Entity\Servicio
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Servicio")
     * @ORM\JoinColumn(name="servicio_id", referencedColumnName="id", nullable=false)
     */
    protected $servicio;

    /**
     * @var \Gopro\ServicioBundle\Entity\Itinerario
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Itinerario")
     * @ORM\JoinColumn(name="itinerario_id", referencedColumnName="id", nullable=false)
     */
    protected $itinerario;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Cotcomponente", mappedBy="cotservicio", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"fechahorainicio" = "ASC"})
     */
    private $cotcomponentes;

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
     * Constructor
     */
    public function __construct()
    {
        $this->cotcomponentes = new ArrayCollection();
        //$this->fechahorainicio = new \DateTime('today');
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
            $this->setCreado(null);
            $this->setModificado(null);
            $newCotcomponentes = new ArrayCollection();
            foreach ($this->cotcomponentes as $cotcomponente) {
                $newCotcomponente = clone $cotcomponente;
                $newCotcomponente->setCotservicio($this);
                $newCotcomponentes->add($newCotcomponente);
            }
            $this->cotcomponentes = $newCotcomponentes;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(empty($this->getServicio())){
            return sprintf("Id: %s.", $this->getId()) ?? '';
        }
        return $this->getServicio()->getNombre();
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
     * Set fechahorainicio
     *
     * @param \DateTime $fechahorainicio
     *
     * @return Cotservicio
     */
    public function setFechahorainicio($fechahorainicio)
    {
        $this->fechahorainicio = $fechahorainicio;
    
        return $this;
    }

    /**
     * Get fechahorainicio
     *
     * @return \DateTime
     */
    public function getFechahorainicio()
    {
        return $this->fechahorainicio;
    }

    /**
     * Set fechahorafin
     *
     * @param \DateTime $fechahorafin
     *
     * @return Cotservicio
     */
    public function setFechahorafin($fechahorafin)
    {
        $this->fechahorafin = $fechahorafin;
    
        return $this;
    }

    /**
     * Get fechahorafin
     *
     * @return \DateTime
     */
    public function getFechahorafin()
    {
        return $this->fechahorafin;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Cotservicio
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
     * @return Cotservicio
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
     * Set cotizacion
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion
     *
     * @return Cotservicio
     */
    public function setCotizacion(\Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion = null)
    {
        $this->cotizacion = $cotizacion;
    
        return $this;
    }

    /**
     * Get cotizacion
     *
     * @return \Gopro\CotizacionBundle\Entity\Cotizacion
     */
    public function getCotizacion()
    {
        return $this->cotizacion;
    }

    /**
     * Set servicio
     *
     * @param \Gopro\ServicioBundle\Entity\Servicio $servicio
     *
     * @return Cotservicio
     */
    public function setServicio(\Gopro\ServicioBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;
    
        return $this;
    }

    /**
     * Get servicio
     *
     * @return \Gopro\ServicioBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set itinerario
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerario $itinerario
     *
     * @return Cotservicio
     */
    public function setItinerario(\Gopro\ServicioBundle\Entity\Itinerario $itinerario = null)
    {
        $this->itinerario = $itinerario;
    
        return $this;
    }

    /**
     * Get itinerario
     *
     * @return \Gopro\ServicioBundle\Entity\Itinerario
     */
    public function getItinerario()
    {
        return $this->itinerario;
    }

    /**
     * Add cotcomponente
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotcomponente $cotcomponente
     *
     * @return Cotservicio
     */
    public function addCotcomponente(\Gopro\CotizacionBundle\Entity\Cotcomponente $cotcomponente)
    {
        $cotcomponente->setCotservicio($this);

        $this->cotcomponentes[] = $cotcomponente;
    
        return $this;
    }

    /**
     * Remove cotcomponente
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotcomponente $cotcomponente
     */
    public function removeCotcomponente(\Gopro\CotizacionBundle\Entity\Cotcomponente $cotcomponente)
    {
        $this->cotcomponentes->removeElement($cotcomponente);
    }

    /**
     * Get cotcomponentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCotcomponentes()
    {
        return $this->cotcomponentes;
    }
}
