<?php
namespace Gopro\ComprobanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="com_comprobanteitem")
 * @ORM\Entity
 */
class Comprobanteitem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\ComprobanteBundle\Entity\Comprobante
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ComprobanteBundle\Entity\Comprobante", inversedBy="comprobanteitems")
     * @ORM\JoinColumn(name="comprobante_id", referencedColumnName="id", nullable=false)
     */
    private $comprobante;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @var \Gopro\ComprobanteBundle\Entity\Productoservicio
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ComprobanteBundle\Entity\Productoservicio")
     * @ORM\JoinColumn(name="productoservicio_id", referencedColumnName="id", nullable=false)
     */
    private $productoservicio;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private $unitario;

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
        return $this->getProductoservicio()->getNombre() ?? '';
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
     * Set unitario
     *
     * @param string $unitario
     *
     * @return Comprobanteitem
     */
    public function setUnitario($unitario)
    {
        $this->unitario = $unitario;

        return $this;
    }

    /**
     * Get unitario
     *
     * @return string
     */
    public function getUnitario()
    {
        return $this->unitario;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Comprobanteitem
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
     * @return Comprobanteitem
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
     * Set comprobante
     *
     * @param \Gopro\ComprobanteBundle\Entity\Comprobante $comprobante
     *
     * @return Comprobanteitem
     */
    public function setComprobante(\Gopro\ComprobanteBundle\Entity\Comprobante $comprobante)
    {
        $this->comprobante = $comprobante;

        return $this;
    }

    /**
     * Get comprobante
     *
     * @return \Gopro\ComprobanteBundle\Entity\Comprobante
     */
    public function getComprobante()
    {
        return $this->comprobante;
    }

    /**
     * Set productoservicio
     *
     * @param \Gopro\ComprobanteBundle\Entity\Productoservicio $productoservicio
     *
     * @return Comprobanteitem
     */
    public function setProductoservicio(\Gopro\ComprobanteBundle\Entity\Productoservicio $productoservicio)
    {
        $this->productoservicio = $productoservicio;

        return $this;
    }

    /**
     * Get productoservicio
     *
     * @return \Gopro\ComprobanteBundle\Entity\Productoservicio
     */
    public function getProductoservicio()
    {
        return $this->productoservicio;
    }

    /**
     * Set cantidad.
     *
     * @param int $cantidad
     *
     * @return Comprobanteitem
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }




}
