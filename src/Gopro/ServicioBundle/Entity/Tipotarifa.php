<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * Tipotarifa
 *
 * @ORM\Table(name="ser_tipotarifa")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\TipotarifaTranslation")
 */
class Tipotarifa implements TranslatableInterface
{
    use PersonalTranslatableTrait;

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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="titulo", type="string", length=100, nullable=false)
     */
    private $titulo;

    /**
     * @var bool
     *
     * @ORM\Column(name="comisionable", type="boolean", options={"default": 0})
     */
    private $comisionable = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="oculto", type="boolean", options={"default": 0})
     */
    private $oculto = false;

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
     *
     * @return Tipotarifa
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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Tipotarifa
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
     * @return Tipotarifa
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
     * Set titulo.
     *
     * @param string|null $titulo
     *
     * @return Tipotarifa
     */
    public function setTitulo($titulo = null)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo.
     *
     * @return string|null
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set comisionable.
     *
     * @param bool $comisionable
     *
     * @return Tipotarifa
     */
    public function setComisionable($comisionable)
    {
        $this->comisionable = $comisionable;
    
        return $this;
    }

    /**
     * Get comisionable.
     *
     * @return bool
     */
    public function getComisionable()
    {
        return $this->comisionable;
    }

    /**
     * Set oculto.
     *
     * @param bool $oculto
     *
     * @return Tipotarifa
     */
    public function seOculto($oculto)
    {
        $this->oculto = $oculto;

        return $this;
    }

    /**
     * Get oculto.
     *
     * @return bool
     */
    public function getOculto()
    {
        return $this->oculto;
    }
}
