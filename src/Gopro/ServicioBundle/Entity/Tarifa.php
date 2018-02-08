<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * Tarifa
 *
 * @ORM\Table(name="ser_tarifa")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\TarifaRepository")
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\TarifaTranslation")
 */
class Tarifa implements TranslatableInterface
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
     * @var bool
     *
     * @ORM\Column(name="prorrateado", type="boolean", options={"default": 0})
     */
    private $prorrateado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="titulo", type="string", length=100, nullable=true)
     */
    private $titulo;

    /**
     * @var \Gopro\MaestroBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Moneda")
     */
    protected $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $monto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validezinicio", type="date")
     */
    private $validezinicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validezfin", type="date")
     */
    private $validezfin;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidadmin", type="integer", nullable=true)
     */
    private $capacidadmin;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidadmax", type="integer", nullable=true)
     */
    private $capacidadmax;

    /**
     * @var int
     *
     * @ORM\Column(name="edadmin", type="integer", nullable=true)
     */
    private $edadmin;

    /**
     * @var int
     *
     * @ORM\Column(name="edadmax", type="integer", nullable=true)
     */
    private $edadmax;

    /**
     * @var \Gopro\ServicioBundle\Entity\Tipotarifa
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Tipotarifa")
     * @ORM\JoinColumn(name="tipotarifa_id", referencedColumnName="id", nullable=false)
     */
    protected $tipotarifa;

    /**
     * @var \Gopro\ServicioBundle\Entity\Componente
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Componente", inversedBy="tarifas")
     * @ORM\JoinColumn(name="componente_id", referencedColumnName="id", nullable=false)
     */
    protected $componente;

    /**
     * @var \Gopro\MaestroBundle\Entity\Categoriatour
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Categoriatour")
     */
    protected $categoriatour;

    /**
     * @var \Gopro\MaestroBundle\Entity\Tipopax
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Tipopax")
     */
    protected $tipopax;

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
        $vars = [];
        $varchain = '';
        if(!empty($this->edadmin)){
           $vars[] = '>=' . $this->edadmin;
        }
        if(!empty($this->edadmax)){
            $vars[] = '<=' . $this->edadmax;
        }
        if(!empty($this->getTipopax())
            && !empty($this->getTipopax()->getId())
        ){
            $vars[] = '(' . strtoupper(substr($this->getTipopax()->getNombre(), 0,2) . ')');
        }
        if(count($vars) > 0){
            $varchain = ', ' . implode(' ', $vars);
        }
        return sprintf('%s%s', $this->getNombre(), $varchain) ?? sprintf("Id: %s.", $this->getId()) ?? '';
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
     * Set prorrateado
     *
     * @param boolean $prorrateado
     *
     * @return Tarifa
     */
    public function setProrrateado($prorrateado)
    {
        $this->prorrateado = $prorrateado;
    
        return $this;
    }

    /**
     * Get prorrateado
     *
     * @return boolean
     */
    public function getProrrateado()
    {
        return $this->prorrateado;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tarifa
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
     * Set monto
     *
     * @param string $monto
     *
     * @return Tarifa
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    
        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set validezinicio
     *
     * @param \DateTime $validezinicio
     *
     * @return Tarifa
     */
    public function setValidezinicio($validezinicio)
    {
        $this->validezinicio = $validezinicio;
    
        return $this;
    }

    /**
     * Get validezinicio
     *
     * @return \DateTime
     */
    public function getValidezinicio()
    {
        return $this->validezinicio;
    }

    /**
     * Set validezfin
     *
     * @param string $validezfin
     *
     * @return Tarifa
     */
    public function setValidezfin($validezfin)
    {
        $this->validezfin = $validezfin;
    
        return $this;
    }

    /**
     * Get validezfin
     *
     * @return string
     */
    public function getValidezfin()
    {
        return $this->validezfin;
    }

    /**
     * Set capacidadmin
     *
     * @param string $capacidadmin
     *
     * @return Tarifa
     */
    public function setCapacidadmin($capacidadmin)
    {
        $this->capacidadmin = $capacidadmin;
    
        return $this;
    }

    /**
     * Get capacidadmin
     *
     * @return string
     */
    public function getCapacidadmin()
    {
        return $this->capacidadmin;
    }

    /**
     * Set capacidadmax
     *
     * @param integer $capacidadmax
     *
     * @return Tarifa
     */
    public function setCapacidadmax($capacidadmax)
    {
        $this->capacidadmax = $capacidadmax;
    
        return $this;
    }

    /**
     * Get capacidadmax
     *
     * @return integer
     */
    public function getCapacidadmax()
    {
        return $this->capacidadmax;
    }

    /**
     * Set edadmin
     *
     * @param integer $edadmin
     *
     * @return Tarifa
     */
    public function setEdadmin($edadmin)
    {
        $this->edadmin = $edadmin;
    
        return $this;
    }

    /**
     * Get edadmin
     *
     * @return integer
     */
    public function getEdadmin()
    {
        return $this->edadmin;
    }

    /**
     * Set edadmax
     *
     * @param integer $edadmax
     *
     * @return Tarifa
     */
    public function setEdadmax($edadmax)
    {
        $this->edadmax = $edadmax;
    
        return $this;
    }

    /**
     * Get edadmax
     *
     * @return integer
     */
    public function getEdadmax()
    {
        return $this->edadmax;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Tarifa
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
     * @return Tarifa
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
     * Set componente
     *
     * @param \Gopro\ServicioBundle\Entity\Componente $componente
     *
     * @return Tarifa
     */
    public function setComponente(\Gopro\ServicioBundle\Entity\Componente $componente = null)
    {
        $this->componente = $componente;
    
        return $this;
    }

    /**
     * Get componente
     *
     * @return \Gopro\ServicioBundle\Entity\Componente
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set categoriatour
     *
     * @param \Gopro\MaestroBundle\Entity\Categoriatour $categoriatour
     *
     * @return Tarifa
     */
    public function setCategoriatour(\Gopro\MaestroBundle\Entity\Categoriatour $categoriatour = null)
    {
        $this->categoriatour = $categoriatour;
    
        return $this;
    }

    /**
     * Get categoriatour
     *
     * @return \Gopro\MaestroBundle\Entity\Categoriatour
     */
    public function getCategoriatour()
    {
        return $this->categoriatour;
    }

    /**
     * Set tipopax
     *
     * @param \Gopro\MaestroBundle\Entity\Tipopax $tipopax
     *
     * @return Tarifa
     */
    public function setTipopax(\Gopro\MaestroBundle\Entity\Tipopax $tipopax = null)
    {
        $this->tipopax = $tipopax;
    
        return $this;
    }

    /**
     * Get tipopax
     *
     * @return \Gopro\MaestroBundle\Entity\Tipopax
     */
    public function getTipopax()
    {
        return $this->tipopax;
    }

    /**
     * Set moneda
     *
     * @param \Gopro\MaestroBundle\Entity\Moneda $moneda
     *
     * @return Tarifa
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Tarifa
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set tipotarifa.
     *
     * @param \Gopro\ServicioBundle\Entity\Tipotarifa|null $tipotarifa
     *
     * @return Tarifa
     */
    public function setTipotarifa(\Gopro\ServicioBundle\Entity\Tipotarifa $tipotarifa = null)
    {
        $this->tipotarifa = $tipotarifa;
    
        return $this;
    }

    /**
     * Get tipotarifa.
     *
     * @return \Gopro\ServicioBundle\Entity\Tipotarifa|null
     */
    public function getTipotarifa()
    {
        return $this->tipotarifa;
    }
}
