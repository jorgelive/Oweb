<?php
namespace Gopro\ComprobanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="com_productoservicio")
 * @ORM\Entity
 */
class Productoservicio
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=50)
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

    /**
     * @var \Gopro\ComprobanteBundle\Entity\Tipoproductoservicio
     *
     * @ORM\ManyToOne(targetEntity="Tipoproductoservicio")
     * @ORM\JoinColumn(name="tipoproductoservicio_id", referencedColumnName="id", nullable=false)
     */
    private $tipoproductoservicio;

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
     * @return Productoservicio
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
     * Set codigo
     *
     * @param string $codigo
     * @return Productoservicio
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return Productoservicio
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
     * @return Productoservicio
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
     * Set tipoproductoservicio
     *
     * @param \Gopro\ComprobanteBundle\Entity\Tipoproductoservicio $tipoproductoservicio
     *
     * @return Productoservicio
     */
    public function setTipoproductoservicio(\Gopro\ComprobanteBundle\Entity\Tipoproductoservicio $tipoproductoservicio)
    {
        $this->tipoproductoservicio = $tipoproductoservicio;

        return $this;
    }

    /**
     * Get tipoproductoservicio
     *
     * @return \Gopro\ComprobanteBundle\Entity\Tipoproductoservicio
     */
    public function getTipoproductoservicio()
    {
        return $this->tipoproductoservicio;
    }

    
}
