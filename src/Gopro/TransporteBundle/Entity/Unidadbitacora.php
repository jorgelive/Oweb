<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tra_unidadbitacora")
 * @ORM\Entity
 */
class Unidadbitacora
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\TransporteBundle\Entity\Unidad
     *
     * @ORM\ManyToOne(targetEntity="Unidad", inversedBy="unidadbitacoras")
     * @ORM\JoinColumn(name="unidad_id", referencedColumnName="id", nullable=false)
     */
    private $unidad;

    /**
     * @var \Gopro\TransporteBundle\Entity\Tipounibit
     *
     * @ORM\ManyToOne(targetEntity="Tipounibit")
     * @ORM\JoinColumn(name="tipounibit_id", referencedColumnName="id", nullable=false)
     */
    private $tipounibit;

    /**
     * @ORM\Column(type="text")
     */
    private $contenido;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometraje", type="integer")
     */
    private $kilometraje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

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
        return $this->getContenido() ?? sprintf("Id: %s.", $this->getId()) ?? '';
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
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Unidadbitacora
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Unidadbitacora
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
     * @return Unidadbitacora
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
     * Set unidad
     *
     * @param \Gopro\TransporteBundle\Entity\Unidad $unidad
     *
     * @return Unidadbitacora
     */
    public function setUnidad(\Gopro\TransporteBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \Gopro\TransporteBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set tipounibit
     *
     * @param \Gopro\TransporteBundle\Entity\Tipounibit $tipounibit
     *
     * @return Unidadbitacora
     */
    public function setTipounibit(\Gopro\TransporteBundle\Entity\Tipounibit $tipounibit = null)
    {
        $this->tipounibit = $tipounibit;

        return $this;
    }

    /**
     * Get tipounibit
     *
     * @return \Gopro\TransporteBundle\Entity\Tipounibit
     */
    public function getTipounibit()
    {
        return $this->tipounibit;
    }

    /**
     * Set fecha.
     *
     * @param \DateTime $fecha
     *
     * @return Unidadbitacora
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha.
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set kilometraje.
     *
     * @param int $kilometraje
     *
     * @return Unidadbitacora
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    
        return $this;
    }

    /**
     * Get kilometraje.
     *
     * @return int
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }
}
