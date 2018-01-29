<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cotpolitica
 *
 * @ORM\Table(name="cot_cotpolitica")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\CotpoliticaRepository")
 * @Gedmo\TranslationEntity(class="Gopro\CotizacionBundle\Entity\CotpoliticaTranslation")
 */
class Cotpolitica implements TranslatableInterface
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
     * @ORM\Column(name="titulo", type="string", length=100)
     */
    private $titulo;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Cotizacion", mappedBy="cotpolitica", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $cotizaciones;

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
        $this->cotizaciones = new ArrayCollection();
    }

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
     * @return Cotpolitica
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
     * @return Cotpolitica
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
     * @return Cotpolitica
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
     * Add cotizacion
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion
     *
     * @return Cotpolitica
     */
    public function addCotizacion(\Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion)
    {
        $cotizacion->setCotpolitica($this);

        $this->cotizaciones[] = $cotizacion;
    
        return $this;
    }


    /**
     * Add cotizacione por inflector ingles
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion
     *
     * @return Cotpolitica
     */
    public function addCotizacione(\Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion){
        return $this->addCotizacion($cotizacion);
    }

    /**
     * Remove cotizacion
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion
     */
    public function removeCotizacion(\Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion)
    {
        $this->cotizaciones->removeElement($cotizacion);
    }

    /**
     * Remove cotizacione por inflector ingles
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion
     */
    public function removeCotizacione(\Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion)
    {
        $this->removeCotizacion($cotizacion);
    }


    /**
     * Get cotizaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCotizaciones()
    {
        return $this->cotizaciones;
    }


    /**
     * Set titulo.
     *
     * @param string $titulo
     *
     * @return Cotpolitica
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo.
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set contenido.
     *
     * @param string $contenido
     *
     * @return Cotpolitica
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    
        return $this;
    }

    /**
     * Get contenido.
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }
}
