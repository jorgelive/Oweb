<?php

namespace Gopro\CuentaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Movimiento
 *
 * @ORM\Table(name="cue_periodo")
 * @ORM\Entity(repositoryClass="Gopro\CuentaBundle\Repository\MovimientoRepository")
 */
class Periodo
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
     * @var \Gopro\CuentaBundle\Entity\Cuenta
     *
     * @ORM\ManyToOne(targetEntity="Cuenta", inversedBy="periodos")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id", nullable=false)
     */
    protected $cuenta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CuentaBundle\Entity\Movimiento", mappedBy="periodo", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"fechahora" = "ASC"})
     */
    private $movimientos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechainicio", type="date")
     */
    private $fechainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafin"
     * , type="date", nullable=true)
     */
    private $fechafin;

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
        $this->movimientos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre(){

        if(empty($this->fechainicio) || empty($this->getCuenta()) || empty($this->getCuenta()->getNombre())){
            return sprintf("Id: %s.", $this->getId()) ?? '';
        }else{
            $parteInicio = sprintf('del %s', $this->fechainicio->format('Y-m-d'));
        }

        $parteFin = '';

        if(!empty($this->fechafin)){
            $parteFin = sprintf(' al %s', $this->fechafin->format('Y-m-d'));
        }

        return sprintf('%s: %s%s', $this->getCuenta()->getNombre(), $parteInicio, $parteFin);
    }




    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechainicio.
     *
     * @param \DateTime $fechainicio
     *
     * @return Periodo
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;
    
        return $this;
    }

    /**
     * Get fechainicio.
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin.
     *
     * @param \DateTime|null $fechafin
     *
     * @return Periodo
     */
    public function setFechafin($fechafin = null)
    {
        $this->fechafin = $fechafin;
    
        return $this;
    }

    /**
     * Get fechafin.
     *
     * @return \DateTime|null
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set creado.
     *
     * @param \DateTime $creado
     *
     * @return Periodo
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;
    
        return $this;
    }

    /**
     * Get creado.
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set modificado.
     *
     * @param \DateTime $modificado
     *
     * @return Periodo
     */
    public function setModificado($modificado)
    {
        $this->modificado = $modificado;
    
        return $this;
    }

    /**
     * Get modificado.
     *
     * @return \DateTime
     */
    public function getModificado()
    {
        return $this->modificado;
    }

    /**
     * Set cuenta.
     *
     * @param \Gopro\CuentaBundle\Entity\Cuenta $cuenta
     *
     * @return Periodo
     */
    public function setCuenta(\Gopro\CuentaBundle\Entity\Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    
        return $this;
    }

    /**
     * Get cuenta.
     *
     * @return \Gopro\CuentaBundle\Entity\Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Add movimiento.
     *
     * @param \Gopro\CuentaBundle\Entity\Movimiento $movimiento
     *
     * @return Periodo
     */
    public function addMovimiento(\Gopro\CuentaBundle\Entity\Movimiento $movimiento)
    {
        $movimiento->setPeriodo($this);

        $this->movimientos[] = $movimiento;
    
        return $this;
    }

    /**
     * Remove movimiento.
     *
     * @param \Gopro\CuentaBundle\Entity\Movimiento $movimiento
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMovimiento(\Gopro\CuentaBundle\Entity\Movimiento $movimiento)
    {
        return $this->movimientos->removeElement($movimiento);
    }

    /**
     * Get movimientos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }
}
