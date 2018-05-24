<?php

namespace Gopro\CuentaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Centro
 *
 * @ORM\Table(name="cue_centro")
 * @ORM\Entity(repositoryClass="Gopro\CuentaBundle\Repository\CentroRepository")
 */
class Centro
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=50)
     */
    private $codigo;

    /**
     * @var \Gopro\TransporteBundle\Entity\Unidad
     *
     * @ORM\OneToOne(targetEntity="Gopro\TransporteBundle\Entity\Unidad", inversedBy="centro")
     * @ORM\JoinColumn(name="unidad_id", referencedColumnName="id", nullable=true)
     */
    protected $unidad;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CuentaBundle\Entity\Movimiento", mappedBy="centro", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"fechahora" = "DESC"})
     */
    private $movimientos;


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
     * @return Centro
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
     * @return Centro
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
     * @return Centro
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
     * @return Centro
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
     * Set unidad.
     *
     * @param \Gopro\TransporteBundle\Entity\Unidad|null $unidad
     *
     * @return Centro
     */
    public function setUnidad(\Gopro\TransporteBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;
    
        return $this;
    }

    /**
     * Get unidad.
     *
     * @return \Gopro\TransporteBundle\Entity\Unidad|null
     */
    public function getUnidad()
    {
        return $this->unidad;
    }


    /**
     * Add movimiento.
     *
     * @param \Gopro\CuentaBundle\Entity\Movimiento $movimiento
     *
     * @return Centro
     */
    public function addMovimiento(\Gopro\CuentaBundle\Entity\Movimiento $movimiento)
    {
        $movimiento->setCentro($this);

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
