<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cotcomponente
 *
 * @ORM\Table(name="cot_cotcomponente")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\CotcomponenteRepository")
 */
class Cotcomponente
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
     * @var \Gopro\CotizacionBundle\Entity\Cotservicio
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\Cotservicio", inversedBy="cotcomponentes")
     */
    protected $cotservicio;

    /**
     * @var \Gopro\ServicioBundle\Entity\Componente
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Componente")
     * @ORM\JoinColumn(name="componente_id", referencedColumnName="id", nullable=false)
     */
    protected $componente;

    /**
     * @var \Gopro\CotizacionBundle\Entity\Estadocotcomponente
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\Estadocotcomponente")
     * @ORM\JoinColumn(name="estadocotcomponente_id", referencedColumnName="id", nullable=false)
     */
    protected $estadocotcomponente;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Cottarifa", mappedBy="cotcomponente", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"tipotarifa" = "ASC"})
     */
    private $cottarifas;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", options={"default": 1})
     */
    private $cantidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahorainicio", type="datetime")
     */
    private $fechahorainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahorafin", type="datetime")
     */
    private $fechahorafin;

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
        $this->cottarifas = new ArrayCollection();
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
            $this->setCreado(null);
            $this->setModificado(null);
            $newCottarifas = new ArrayCollection();
            foreach ($this->cottarifas as $cottarifa) {
                $newCottarifa = clone $cottarifa;
                $newCottarifa->setCotcomponente($this);
                $newCottarifas->add($newCottarifa);
            }
            $this->cottarifas = $newCottarifas;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(empty($this->getComponente())){
            return sprintf('id: %s', $this->getId());
        }
        return $this->getComponente()->getNombre();
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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Cotcomponente
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
     * @return Cotcomponente
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
     * Set estadocotcomponente
     *
     * @param \Gopro\CotizacionBundle\Entity\Estadocotcomponente $estadocotcomponente
     *
     * @return Cotcomponente
     */
    public function setEstadocotcomponente(\Gopro\CotizacionBundle\Entity\Estadocotcomponente $estadocotcomponente)
    {
        $this->estadocotcomponente = $estadocotcomponente;

        return $this;
    }

    /**
     * Get estadocotcomponente
     *
     * @return \Gopro\CotizacionBundle\Entity\Estadocotcomponente
     */
    public function getEstadocotcomponente()
    {
        return $this->estadocotcomponente;
    }

    /**
     * Set cotservicio
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotservicio $cotservicio
     *
     * @return Cotcomponente
     */
    public function setCotservicio(\Gopro\CotizacionBundle\Entity\Cotservicio $cotservicio = null)
    {
        $this->cotservicio = $cotservicio;
    
        return $this;
    }

    /**
     * Get cotservicio
     *
     * @return \Gopro\CotizacionBundle\Entity\Cotservicio
     */
    public function getCotservicio()
    {
        return $this->cotservicio;
    }

    /**
     * Set componente
     *
     * @param \Gopro\ServicioBundle\Entity\Componente $componente
     *
     * @return Cotcomponente
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
     * Add cottarifa
     *
     * @param \Gopro\CotizacionBundle\Entity\Cottarifa $cottarifa
     *
     * @return Cotcomponente
     */
    public function addCottarifa(\Gopro\CotizacionBundle\Entity\Cottarifa $cottarifa)
    {
        $cottarifa->setCotcomponente($this);

        $this->cottarifas[] = $cottarifa;
    
        return $this;
    }

    /**
     * Remove cottarifa
     *
     * @param \Gopro\CotizacionBundle\Entity\Cottarifa $cottarifa
     */
    public function removeCottarifa(\Gopro\CotizacionBundle\Entity\Cottarifa $cottarifa)
    {
        $this->cottarifas->removeElement($cottarifa);
    }

    /**
     * Get cottarifas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCottarifas()
    {
        return $this->cottarifas;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Cotcomponente
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set fechahorainicio
     *
     * @param \DateTime $fechahorainicio
     *
     * @return Cotcomponente
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
     * Set fechahorafin.
     *
     * @param \DateTime|null $fechahorafin
     *
     * @return Cotcomponente
     */
    public function setFechahorafin($fechahorafin = null)
    {
        $this->fechahorafin = $fechahorafin;
    
        return $this;
    }

    /**
     * Get fechahorafin.
     *
     * @return \DateTime|null
     */
    public function getFechahorafin()
    {
        return $this->fechahorafin;
    }
}
