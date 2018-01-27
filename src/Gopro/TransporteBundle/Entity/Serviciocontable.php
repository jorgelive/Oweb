<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tra_serviciocontable")
 * @ORM\Entity
 */
class Serviciocontable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\TransporteBundle\Entity\Servicio
     *
     * @ORM\ManyToOne(targetEntity="Servicio", inversedBy="serviciocontables")
     * @ORM\JoinColumn(name="servicio_id", referencedColumnName="id", nullable=false)
     */
    private $servicio;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $descripcion;

    /**
     * @var \Gopro\MaestroBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Moneda")
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id", nullable=false)
     */
    private $moneda;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $neto;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $impuesto;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $total;

    /**
     * @var \Gopro\TransporteBundle\Entity\Tiposercontable
     *
     * @ORM\ManyToOne(targetEntity="Tiposercontable")
     * @ORM\JoinColumn(name="tiposercontable_id", referencedColumnName="id", nullable=false)
     */
    private $tiposercontable;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $serie;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $documento;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaemision;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $url;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Sercontablemensaje", mappedBy="serviciocontable", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $sercontablemensajes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciocontable", mappedBy="original", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $dependientes;

    /**
     * @var \Gopro\TransporteBundle\Entity\Serviciocontable
     *
     * @ORM\ManyToOne(targetEntity="Serviciocontable", inversedBy="dependientes")
     */
    private $original;

    /**
     * @var \Gopro\TransporteBundle\Entity\Estadocontable
     *
     * @ORM\ManyToOne(targetEntity="Estadocontable")
     * @ORM\JoinColumn(name="estadocontable_id", referencedColumnName="id", nullable=false)
     */
    private $estadocontable;



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

    public function __construct()
    {
        $this->dependientes = new ArrayCollection();
        $this->sercontablemensajes = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!empty($this->getDocumento()) && !empty($this->getSerie())){
            return sprintf('%s-%s-%s', $this->getTiposercontable()->getCodigo(), $this->getSerie() , str_pad($this->getDocumento(), 5, "0", STR_PAD_LEFT));
        }elseif(!empty($this->getServicio())
            && !empty($this->getServicio()->getDependencia())
            && !empty($this->getServicio()->getDependencia()->getOrganizaciondependencia()
            )
        ){
            return sprintf('%s-%s-%s', $this->getTiposercontable()->getCodigo(), $this->getServicio()->getDependencia()->getOrganizaciondependencia() , $this->getDescripcion());
        }else{
            return '';
        }
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Serviciocontable
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set neto
     *
     * @param string $neto
     *
     * @return Serviciocontable
     */
    public function setNeto($neto)
    {
        $this->neto = $neto;

        return $this;
    }

    /**
     * Get neto
     *
     * @return string
     */
    public function getNeto()
    {
        return $this->neto;
    }

    /**
     * Set impuesto
     *
     * @param string $impuesto
     *
     * @return Serviciocontable
     */
    public function setImpuesto($impuesto)
    {
        $this->impuesto = $impuesto;

        return $this;
    }

    /**
     * Get impuesto
     *
     * @return string
     */
    public function getImpuesto()
    {
        return $this->impuesto;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Serviciocontable
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return Serviciocontable
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return Serviciocontable
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Serviciocontable
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
     * @return Serviciocontable
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
     * Set servicio
     *
     * @param \Gopro\TransporteBundle\Entity\Servicio $servicio
     *
     * @return Serviciocontable
     */
    public function setServicio(\Gopro\TransporteBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \Gopro\TransporteBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set moneda
     *
     * @param \Gopro\MaestroBundle\Entity\Moneda $moneda
     *
     * @return Serviciocontable
     */
    public function setMoneda(\Gopro\MaestroBundle\Entity\Moneda $moneda = null)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return \Gopro\MaestroBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set tiposercontable
     *
     * @param \Gopro\TransporteBundle\Entity\Tiposercontable $tiposercontable
     *
     * @return Serviciocontable
     */
    public function setTiposercontable(\Gopro\TransporteBundle\Entity\Tiposercontable $tiposercontable = null)
    {
        $this->tiposercontable = $tiposercontable;

        return $this;
    }

    /**
     * Get tiposercontable
     *
     * @return \Gopro\TransporteBundle\Entity\Tiposercontable
     */
    public function getTiposercontable()
    {
        return $this->tiposercontable;
    }

    /**
     * Set estadocontable
     *
     * @param \Gopro\TransporteBundle\Entity\Estadocontable $estadocontable
     *
     * @return Serviciocontable
     */
    public function setEstadocontable(\Gopro\TransporteBundle\Entity\Estadocontable $estadocontable = null)
    {
        $this->estadocontable = $estadocontable;

        return $this;
    }

    /**
     * Get estadocontable
     *
     * @return \Gopro\TransporteBundle\Entity\Estadocontable
     */
    public function getEstadocontable()
    {
        return $this->estadocontable;
    }

    /**
     * Set fechaemision
     *
     * @param \DateTime $fechaemision
     *
     * @return Serviciocontable
     */
    public function setFechaemision($fechaemision)
    {
        $this->fechaemision = $fechaemision;

        return $this;
    }

    /**
     * Get fechaemision
     *
     * @return \DateTime
     */
    public function getFechaemision()
    {
        return $this->fechaemision;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Serviciocontable
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add dependiente
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $dependiente
     *
     * @return Serviciocontable
     */
    public function addDependiente(\Gopro\TransporteBundle\Entity\Serviciocontable $dependiente)
    {
        $dependiente->setOriginal($this);

        $this->dependientes[] = $dependiente;

        return $this;
    }

    /**
     * Remove dependiente
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $dependiente
     */
    public function removeDependiente(\Gopro\TransporteBundle\Entity\Serviciocontable $dependiente)
    {
        $this->dependientes->removeElement($dependiente);
    }

    /**
     * Get dependientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDependientes()
    {
        return $this->dependientes;
    }

    /**
     * Set original
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $original
     *
     * @return Serviciocontable
     */
    public function setOriginal(\Gopro\TransporteBundle\Entity\Serviciocontable $original = null)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return \Gopro\TransporteBundle\Entity\Serviciocontable
     */
    public function getOriginal()
    {
        return $this->original;
    }


    /**
     * Add sercontablemensaje
     *
     * @param \Gopro\TransporteBundle\Entity\Sercontablemensaje $sercontablemensaje
     *
     * @return Serviciocontable
     */
    public function addSercontablemensaje(\Gopro\TransporteBundle\Entity\Sercontablemensaje $sercontablemensaje)
    {
        $sercontablemensaje->setServiciocontable($this);

        $this->sercontablemensajes[] = $sercontablemensaje;

        return $this;
    }

    /**
     * Remove sercontablemensaje
     *
     * @param \Gopro\TransporteBundle\Entity\Sercontablemensaje $sercontablemensaje
     */
    public function removeSercontablemensaje(\Gopro\TransporteBundle\Entity\Sercontablemensaje $sercontablemensaje)
    {
        $this->sercontablemensajes->removeElement($sercontablemensaje);
    }

    /**
     * Get sercontablemensajes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSercontablemensajes()
    {
        return $this->sercontablemensajes;
    }
}
