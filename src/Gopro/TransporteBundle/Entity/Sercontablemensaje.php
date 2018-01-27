<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tra_sercontablemensaje")
 * @ORM\Entity
 */
class Sercontablemensaje
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
     * @var \Gopro\TransporteBundle\Entity\Serviciocontable
     *
     * @ORM\ManyToOne(targetEntity="Serviciocontable", inversedBy="sercontablemensajes")
     * @ORM\JoinColumn(name="serviciocontable_id", referencedColumnName="id", nullable=false)
     */
    private $serviciocontable;

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
     * @return Sercontablemensaje
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
     * @return Sercontablemensaje
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
     * @return Sercontablemensaje
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
     * @return Sercontablemensaje
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
     * Set serviciocontable
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     *
     * @return Sercontablemensaje
     */
    public function setServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable = null)
    {
        $this->serviciocontable = $serviciocontable;

        return $this;
    }

    /**
     * Get serviciocontable
     *
     * @return \Gopro\TransporteBundle\Entity\Serviciocontable
     */
    public function getServiciocontable()
    {
        return $this->serviciocontable;
    }
}
