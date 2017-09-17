<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tra_serviciooperativo")
 * @ORM\Entity
 */
class Serviciooperativo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\TransporteBundle\Entity\Servicio
     *
     * @ORM\ManyToOne(targetEntity="Servicio", inversedBy="serviciooperativos")
     */
    private $servicio;

    /**
     * @var \Gopro\TransporteBundle\Entity\Tiposeroperativo
     *
     * @ORM\ManyToOne(targetEntity="Tiposeroperativo")
     */
    private $tiposeroperativo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $texto;

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
        if(is_null($this->getTexto())) {
            return 'NULL';
        }

        return $this->getTexto();
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
     * Set texto
     *
     * @param string $texto
     *
     * @return Serviciooperativo
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Serviciooperativo
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
     * @return Serviciooperativo
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
     * Set servicio
     *
     * @param \Gopro\TransporteBundle\Entity\Servicio $servicio
     *
     * @return Serviciooperativo
     */
    public function setServicio(\Gopro\TransporteBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \Gopro\TransporteBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set tiposeroperativo
     *
     * @param \Gopro\TransporteBundle\Entity\Tiposeroperativo $tiposeroperativo
     *
     * @return Serviciooperativo
     */
    public function setTiposeroperativo(\Gopro\TransporteBundle\Entity\Tiposeroperativo $tiposeroperativo = null)
    {
        $this->tiposeroperativo = $tiposeroperativo;

        return $this;
    }

    /**
     * Get tiposeroperativo
     *
     * @return \Gopro\TransporteBundle\Entity\Tiposeroperativo
     */
    public function getTiposeroperativo()
    {
        return $this->tiposeroperativo;
    }
}
