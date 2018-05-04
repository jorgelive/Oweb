<?php
namespace Gopro\ComprobanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="com_comprobante")
 * @ORM\Entity
 */
class Comprobante
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
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id", nullable=false)
     */
    private $dependencia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\TransporteBundle\Entity\Serviciocontable", mappedBy="comprobante", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciocontables;

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
     * @var \Gopro\ComprobanteBundle\Entity\Tipo
     *
     * @ORM\ManyToOne(targetEntity="Tipo")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=false)
     */
    private $tipo;

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
     * @ORM\OneToMany(targetEntity="Mensaje", mappedBy="comprobante", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $mensajes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Comprobante", mappedBy="original", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $dependientes;

    /**
     * @var \Gopro\ComprobanteBundle\Entity\Comprobante
     *
     * @ORM\ManyToOne(targetEntity="Comprobante", inversedBy="dependientes")
     */
    private $original;

    /**
     * @var \Gopro\ComprobanteBundle\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=false)
     */
    private $estado;



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
        $this->serviciocontables = new ArrayCollection();
        $this->dependientes = new ArrayCollection();
        $this->mensajes = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!empty($this->getDocumento()) && !empty($this->getSerie())){
            return sprintf('%s-%s-%s', $this->getTipo()->getCodigo(), $this->getSerie() , str_pad($this->getDocumento(), 5, "0", STR_PAD_LEFT));
        }elseif(!empty($this->getServicio())
            && !empty($this->getServicio()->getDependencia())
            && !empty($this->getServicio()->getDependencia()->getOrganizaciondependencia()
            )
        ){
            return sprintf('%s-%s-%s', $this->getTipo()->getCodigo(), $this->getServicio()->getDependencia()->getOrganizaciondependencia() , $this->getDescripcion());
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
     * @return Comprobante
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
     * @return Comprobante
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
     * @return Comprobante
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
     * @return Comprobante
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
     * @return Comprobante
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
     * @return Comprobante
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
     * Get seriedocumento
     *
     * @return string
     */
    public function getSeriedocumento()
    {
        return sprintf('%s-%s', $this->serie, $this->documento);
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Comprobante
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
     * @return Comprobante
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
     * @return Comprobante
     */
    public function setDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencia)
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
     * Set moneda
     *
     * @param \Gopro\MaestroBundle\Entity\Moneda $moneda
     *
     * @return Comprobante
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
     * Set tipo
     *
     * @param \Gopro\ComprobanteBundle\Entity\Tipo $tipo
     *
     * @return Comprobante
     */
    public function setTipo(\Gopro\ComprobanteBundle\Entity\Tipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Gopro\ComprobanteBundle\Entity\Tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set estado
     *
     * @param \Gopro\ComprobanteBundle\Entity\Estado $estado
     *
     * @return Comprobante
     */
    public function setEstado(\Gopro\ComprobanteBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Gopro\ComprobanteBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaemision
     *
     * @param \DateTime $fechaemision
     *
     * @return Comprobante
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
     * @return Comprobante
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
     * @param \Gopro\ComprobanteBundle\Entity\Comprobante $dependiente
     *
     * @return Comprobante
     */
    public function addDependiente(\Gopro\ComprobanteBundle\Entity\Comprobante $dependiente)
    {
        $dependiente->setOriginal($this);

        $this->dependientes[] = $dependiente;

        return $this;
    }

    /**
     * Remove dependiente
     *
     * @param \Gopro\ComprobanteBundle\Entity\Comprobante $dependiente
     */
    public function removeDependiente(\Gopro\ComprobanteBundle\Entity\Comprobante $dependiente)
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
     * @param \Gopro\ComprobanteBundle\Entity\Comprobante $original
     *
     * @return Comprobante
     */
    public function setOriginal(\Gopro\ComprobanteBundle\Entity\Comprobante $original = null)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return \Gopro\ComprobanteBundle\Entity\Comprobante
     */
    public function getOriginal()
    {
        return $this->original;
    }


    /**
     * Add mensaje
     *
     * @param \Gopro\ComprobanteBundle\Entity\Mensaje $mensaje
     *
     * @return Comprobante
     */
    public function addMensaje(\Gopro\ComprobanteBundle\Entity\Mensaje $mensaje)
    {
        $mensaje->setComprobante($this);

        $this->mensajes[] = $mensaje;

        return $this;
    }

    /**
     * Remove mensaje
     *
     * @param \Gopro\ComprobanteBundle\Entity\Mensaje $mensaje
     */
    public function removeMensaje(\Gopro\ComprobanteBundle\Entity\Mensaje $mensaje)
    {
        $this->mensajes->removeElement($mensaje);
    }

    /**
     * Get mensajes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMensajes()
    {
        return $this->mensajes;
    }

    /**
     * Add serviciocontable.
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     *
     * @return Comprobante
     */
    public function addServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable)
    {
        $serviciocontable->setComprobante($this);

        $this->serviciocontables[] = $serviciocontable;
    
        return $this;
    }

    /**
     * Remove serviciocontable.
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable)
    {
        return $this->serviciocontables->removeElement($serviciocontable);
    }

    /**
     * Get serviciocontables.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciocontables()
    {
        return $this->serviciocontables;
    }
}
