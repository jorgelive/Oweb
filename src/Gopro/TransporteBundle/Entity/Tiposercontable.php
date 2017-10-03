<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tra_tiposercontable")
 * @ORM\Entity
 */
class Tiposercontable
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
     * @ORM\Column(type="string", length=3)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $codigoexterno;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $serie;

    /**
     * @ORM\Column(type="integer")
     */
    private $correlativo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $esnotacredito;

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
        if(is_null($this->getNombre())) {
            return sprintf("Id: %s.", $this->getId());
        }

        return $this->getNombre();
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
     * @return Tiposercontable
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
     * @return Tiposercontable
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
     * @return Tiposercontable
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
     * @return Tiposercontable
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
     * Set serie
     *
     * @param string $serie
     *
     * @return Tiposercontable
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set correlativo
     *
     * @param integer $correlativo
     *
     * @return Tiposercontable
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * Get correlativo
     *
     * @return integer
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * Set codigoexterno
     *
     * @param string $codigoexterno
     *
     * @return Tiposercontable
     */
    public function setCodigoexterno($codigoexterno)
    {
        $this->codigoexterno = $codigoexterno;

        return $this;
    }

    /**
     * Get codigoexterno
     *
     * @return string
     */
    public function getCodigoexterno()
    {
        return $this->codigoexterno;
    }

    /**
     * Set esnotacredito
     *
     * @param boolean $esnotacredito
     *
     * @return Tiposercontable
     */
    public function setEsnotacredito($esnotacredito)
    {
        $this->esnotacredito = $esnotacredito;

        return $this;
    }

    /**
     * Get ennotacredito
     *
     * @return boolean
     */
    public function getEsnotacredito()
    {
        return $this->esnotacredito;
    }
}
