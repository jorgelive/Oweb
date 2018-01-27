<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cottarifa
 *
 * @ORM\Table(name="cot_cottarifa")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\CottarifaRepository")
 */
class Cottarifa
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
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var \Gopro\CotizacionBundle\Entity\Cotcomponente
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\Cotcomponente", inversedBy="cottarifas")
     * @ORM\JoinColumn(name="cotcomponente_id", referencedColumnName="id", nullable=false)
     */
    protected $cotcomponente;

    /**
     * @var \Gopro\ServicioBundle\Entity\Tarifa
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Tarifa")
     * @ORM\JoinColumn(name="tarifa_id", referencedColumnName="id", nullable=false)
     */
    protected $tarifa;

    /**
     * @var \Gopro\MaestroBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Moneda")
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id", nullable=false)
     */
    protected $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=7, scale=2, nullable=false)
     */
    private $monto;

    /**
     * @var \Gopro\ServicioBundle\Entity\Tipotarifa
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Tipotarifa")
     * @ORM\JoinColumn(name="tipotarifa_id", referencedColumnName="id", nullable=false)
     */
    protected $tipotarifa;

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

        if(empty($this->getTarifa())){
            return $this->getNombre() ?? sprintf("Id: %s.", $this->getId()) ?? '';
        }
        return $this->getTarifa()->getNombre();
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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Cottarifa
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
     * Set monto
     *
     * @param string $monto
     *
     * @return Cottarifa
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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Cottarifa
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
     * @return Cottarifa
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
     * Set cotcomponente
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotcomponente $cotcomponente
     *
     * @return Cottarifa
     */
    public function setCotcomponente(\Gopro\CotizacionBundle\Entity\Cotcomponente $cotcomponente = null)
    {
        $this->cotcomponente = $cotcomponente;
    
        return $this;
    }

    /**
     * Get cotcomponente
     *
     * @return \Gopro\CotizacionBundle\Entity\Cotcomponente
     */
    public function getCotcomponente()
    {
        return $this->cotcomponente;
    }

    /**
     * Set tarifa
     *
     * @param \Gopro\ServicioBundle\Entity\Tarifa $tarifa
     *
     * @return Cottarifa
     */
    public function setTarifa(\Gopro\ServicioBundle\Entity\Tarifa $tarifa = null)
    {
        $this->tarifa = $tarifa;
    
        return $this;
    }

    /**
     * Get tarifa
     *
     * @return \Gopro\ServicioBundle\Entity\Tarifa
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }

    /**
     * Set moneda
     *
     * @param \Gopro\MaestroBundle\Entity\Moneda $moneda
     *
     * @return Cottarifa
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
     * Set tipotarifa
     *
     * @param \Gopro\ServicioBundle\Entity\Tipotarifa $tipotarifa
     *
     * @return Cottarifa
     */
    public function setTipotarifa(\Gopro\ServicioBundle\Entity\Tipotarifa $tipotarifa = null)
    {
        $this->tipotarifa = $tipotarifa;
    
        return $this;
    }

    /**
     * Get tipotarifa
     *
     * @return \Gopro\ServicioBundle\Entity\Tipotarifa
     */
    public function getTipotarifa()
    {
        return $this->tipotarifa;
    }
}
