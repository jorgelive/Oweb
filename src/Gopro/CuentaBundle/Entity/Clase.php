<?php

namespace Gopro\CuentaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Clase
 *
 * @ORM\Table(name="cue_clase")
 * @ORM\Entity(repositoryClass="Gopro\CuentaBundle\Repository\ClaseRepository")
 */
class Clase
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
     * @var \Gopro\CuentaBundle\Entity\Tipo
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CuentaBundle\Entity\Tipo", inversedBy="clases")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=false)
     */
    protected $tipo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CuentaBundle\Entity\Movimiento", mappedBy="clase", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $movimientos;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

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
     * @return Clase
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
     * Set codigo.
     *
     * @param string $codigo
     *
     * @return Clase
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo.
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set creado.
     *
     * @param \DateTime $creado
     *
     * @return Clase
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
     * @return Clase
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
     * Set tipo.
     *
     * @param \Gopro\CuentaBundle\Entity\Tipo $tipo
     *
     * @return Clase
     */
    public function setTipo(\Gopro\CuentaBundle\Entity\Tipo $tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo.
     *
     * @return \Gopro\CuentaBundle\Entity\Tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Add movimiento.
     *
     * @param \Gopro\CuentaBundle\Entity\Movimiento $movimiento
     *
     * @return Clase
     */
    public function addMovimiento(\Gopro\CuentaBundle\Entity\Movimiento $movimiento)
    {
        $movimiento->setClase($this);

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
