<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * Cotizacion
 *
 * @ORM\Table(name="cot_cotizacion")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\CotizacionRepository")
 * @Gedmo\TranslationEntity(class="Gopro\CotizacionBundle\Entity\CotizacionTranslation")
 */
class Cotizacion implements TranslatableInterface
{
    use PersonalTranslatableTrait;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="numeropasajeros", type="integer")
     */
    private $numeropasajeros;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $comision = '20.00';

    /**
     * @var \Gopro\CotizacionBundle\Entity\Estadocotizacion
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\Estadocotizacion")
     * @ORM\JoinColumn(name="estadocotizacion_id", referencedColumnName="id", nullable=false)
     */
    protected $estadocotizacion;

    /**
     * @var \Gopro\CotizacionBundle\Entity\File
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\File", inversedBy="cotizaciones")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     */
    protected $file;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Cotservicio", mappedBy="cotizacion", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"fechahorainicio" = "ASC"})
     */
    private $cotservicios;

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
        $this->cotservicios = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre() ?? sprintf("Id: %s.", $this->getId()) ?? '';
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
     * @return Cotizacion
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
     * Set numeropasajeros
     *
     * @param integer $numeropasajeros
     *
     * @return Cotizacion
     */
    public function setNumeropasajeros($numeropasajeros)
    {
        $this->numeropasajeros = $numeropasajeros;
    
        return $this;
    }

    /**
     * Get numeropasajeros
     *
     * @return integer
     */
    public function getNumeropasajeros()
    {
        return $this->numeropasajeros;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Cotizacion
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
     * @return Cotizacion
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
     * Set estadocotizacion
     *
     * @param \Gopro\CotizacionBundle\Entity\Estadocotizacion $estadocotizacion
     *
     * @return Cotizacion
     */
    public function setEstadocotizacion(\Gopro\CotizacionBundle\Entity\Estadocotizacion $estadocotizacion = null)
    {
        $this->estadocotizacion = $estadocotizacion;
    
        return $this;
    }

    /**
     * Get estadocotizacion
     *
     * @return \Gopro\CotizacionBundle\Entity\Estadocotizacion
     */
    public function getEstadocotizacion()
    {
        return $this->estadocotizacion;
    }

    /**
     * Set file
     *
     * @param \Gopro\CotizacionBundle\Entity\File $file
     *
     * @return Cotizacion
     */
    public function setFile(\Gopro\CotizacionBundle\Entity\File $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Gopro\CotizacionBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add cotservicio
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotservicio $cotservicio
     *
     * @return Cotizacion
     */
    public function addCotservicio(\Gopro\CotizacionBundle\Entity\Cotservicio $cotservicio)
    {
        $cotservicio->setCotizacion($this);

        $this->cotservicios[] = $cotservicio;
    
        return $this;
    }

    /**
     * Remove cotservicio
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotservicio $cotservicio
     */
    public function removeCotservicio(\Gopro\CotizacionBundle\Entity\Cotservicio $cotservicio)
    {
        $this->cotservicios->removeElement($cotservicio);
    }

    /**
     * Get cotservicios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCotservicios()
    {
        return $this->cotservicios;
    }

    /**
     * Set comision.
     *
     * @param string $comision
     *
     * @return Cotizacion
     */
    public function setComision($comision)
    {
        $this->comision = $comision;
    
        return $this;
    }

    /**
     * Get comision.
     *
     * @return string
     */
    public function getComision()
    {
        return $this->comision;
    }
}
