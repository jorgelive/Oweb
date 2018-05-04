<?php
namespace Gopro\ComprobanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="com_mensaje")
 * @ORM\Entity
 */
class Mensaje
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $clave;

    /**
     * @ORM\Column(type="text")
     */
    private $contenido;

    /**
     * @var \Gopro\ComprobanteBundle\Entity\Comprobante
     *
     * @ORM\ManyToOne(targetEntity="Comprobante", inversedBy="mensajes")
     * @ORM\JoinColumn(name="comprobante_id", referencedColumnName="id", nullable=false)
     */
    private $comprobante;

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
        return sprintf('%s : %s', $this->getClave(), $this->getContenido());
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
     * Set clave
     *
     * @param string $clave
     *
     * @return Mensaje
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Mensaje
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
     * @return Mensaje
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
     * @return Mensaje
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
     * @return Mensaje
     */
    public function setComprobante(\Gopro\ComprobanteBundle\Entity\Comprobante $comprobante = null)
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
}
