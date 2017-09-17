<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     */
    private $servicio;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descripcion;

    /**
     * @var \Gopro\MaestroBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Moneda")
     */
    private $moneda;

    /**
     * @ORM\Column(type="decimal")
     */
    private $neto;

    /**
     * @ORM\Column(type="decimal")
     */
    private $impuesto;

    /**
     * @ORM\Column(type="decimal")
     */
    private $total;

    /**
     * @var \Gopro\TransporteBundle\Entity\Tiposercontable
     *
     * @ORM\ManyToOne(targetEntity="Tiposercontable")
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
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $serieasociado;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $documentoasociado;

    /**
     * @var \Gopro\MaestroBundle\Entity\Estadocontable
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Estadocontable")
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

    /**
     * @return string
     */
    public function __toString()
    {
        if(is_null($this->getDescripcion())) {
            return 'NULL';
        }

        return $this->getDescripcion();
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
     * Set serieasociado
     *
     * @param string $serieasociado
     *
     * @return Serviciocontable
     */
    public function setSerieasociado($serieasociado)
    {
        $this->serieasociado = $serieasociado;

        return $this;
    }

    /**
     * Get serieasociado
     *
     * @return string
     */
    public function getSerieasociado()
    {
        return $this->serieasociado;
    }

    /**
     * Set documentoasociado
     *
     * @param string $documentoasociado
     *
     * @return Serviciocontable
     */
    public function setDocumentoasociado($documentoasociado)
    {
        $this->documentoasociado = $documentoasociado;

        return $this;
    }

    /**
     * Get documentoasociado
     *
     * @return string
     */
    public function getDocumentoasociado()
    {
        return $this->documentoasociado;
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
     * @param \Gopro\MaestroBundle\Entity\Estadocontable $estadocontable
     *
     * @return Serviciocontable
     */
    public function setEstadocontable(\Gopro\MaestroBundle\Entity\Estadocontable $estadocontable = null)
    {
        $this->estadocontable = $estadocontable;

        return $this;
    }

    /**
     * Get estadocontable
     *
     * @return \Gopro\MaestroBundle\Entity\Estadocontable
     */
    public function getEstadocontable()
    {
        return $this->estadocontable;
    }
}
