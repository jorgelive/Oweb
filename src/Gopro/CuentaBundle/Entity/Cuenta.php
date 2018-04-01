<?php

namespace Gopro\CuentaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cuenta
 *
 * @ORM\Table(name="cue_cuenta")
 * @ORM\Entity(repositoryClass="Gopro\CuentaBundle\Repository\CuentaRepository")
 */
class Cuenta
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var \Gopro\MaestroBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Moneda")
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id", nullable=false)
     */
    protected $moneda;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CuentaBundle\Entity\Periodo", mappedBy="cuenta", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"fechainicio" = "DESC"})
     */
    private $periodos;

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
        $this->periodos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre() ?? sprintf("Id: %s.", $this->getId()) ?? '';
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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Cuenta
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set creado.
     *
     * @param \DateTime $creado
     *
     * @return Cuenta
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
     * @return Cuenta
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
     * Set moneda.
     *
     * @param \Gopro\MaestroBundle\Entity\Moneda $moneda
     *
     * @return Cuenta
     */
    public function setMoneda(\Gopro\MaestroBundle\Entity\Moneda $moneda)
    {
        $this->moneda = $moneda;
    
        return $this;
    }

    /**
     * Get moneda.
     *
     * @return \Gopro\MaestroBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Add periodo.
     *
     * @param \Gopro\CuentaBundle\Entity\Periodo $periodo
     *
     * @return Cuenta
     */
    public function addPeriodo(\Gopro\CuentaBundle\Entity\Periodo $periodo)
    {
        $periodo->setCuenta($this);

        $this->periodos[] = $periodo;
    
        return $this;
    }

    /**
     * Remove periodo.
     *
     * @param \Gopro\CuentaBundle\Entity\Periodo $periodo
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePeriodo(\Gopro\CuentaBundle\Entity\Periodo $periodo)
    {
        return $this->periodos->removeElement($periodo);
    }

    /**
     * Get periodos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeriodos()
    {
        return $this->periodos;
    }
}
