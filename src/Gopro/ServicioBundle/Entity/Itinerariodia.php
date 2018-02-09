<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Itinerariodia
 *
 * @ORM\Table(name="ser_itinerariodia")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\ItinerariodiaRepository")
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\ItinerariodiaTranslation")
 */
class Itinerariodia implements TranslatableInterface
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
     * @var \Gopro\ServicioBundle\Entity\Itinerario
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Itinerario", inversedBy="itinerariodias")
     * @ORM\JoinColumn(name="itinerario_id", referencedColumnName="id", nullable=false)
     */
    protected $itinerario;

    /**
     * @var int
     *
     * @ORM\Column(name="dia", type="integer")
     */
    private $dia = 1;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="titulo", type="string", length=100)
     */
    private $titulo;

    /**
     * @var bool
     *
     * @ORM\Column(name="importante", type="boolean", options={"default": 1})
     */
    private $importante;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\ServicioBundle\Entity\Itidiaarchivo", mappedBy="itinerariodia", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $itidiaarchivos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itidiaarchivos = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s dia %d', $this->getItinerario()->getNombre(), $this->getDia());
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
     * Set dia
     *
     * @param integer $dia
     *
     * @return Itinerariodia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    
        return $this;
    }

    /**
     * Get dia
     *
     * @return integer
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Itinerariodia
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Itinerariodia
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
     * @return Itinerariodia
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
     * @return Itinerariodia
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
     * Set itinerario
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerario $itinerario
     *
     * @return Itinerariodia
     */
    public function setItinerario(\Gopro\ServicioBundle\Entity\Itinerario $itinerario = null)
    {
        $this->itinerario = $itinerario;
    
        return $this;
    }

    /**
     * Get itinerario
     *
     * @return \Gopro\ServicioBundle\Entity\Itinerario
     */
    public function getItinerario()
    {
        return $this->itinerario;
    }


    /**
     * Add itidiaarchivo.
     *
     * @param \Gopro\ServicioBundle\Entity\Itidiaarchivo $itidiaarchivo
     *
     * @return Itinerariodia
     */
    public function addItidiaarchivo(\Gopro\ServicioBundle\Entity\Itidiaarchivo $itidiaarchivo)
    {
        $itidiaarchivo->setItinerariodia($this);

        $this->itidiaarchivos[] = $itidiaarchivo;
    
        return $this;
    }

    /**
     * Remove itidiaarchivo.
     *
     * @param \Gopro\ServicioBundle\Entity\Itidiaarchivo $itidiaarchivo
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeItidiaarchivo(\Gopro\ServicioBundle\Entity\Itidiaarchivo $itidiaarchivo)
    {
        return $this->itidiaarchivos->removeElement($itidiaarchivo);
    }

    /**
     * Get itidiaarchivos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItidiaarchivos()
    {
        return $this->itidiaarchivos;
    }

    /**
     * Set importante.
     *
     * @param bool $importante
     *
     * @return Itinerariodia
     */
    public function setImportante($importante)
    {
        $this->importante = $importante;
    
        return $this;
    }

    /**
     * Get importante.
     *
     * @return bool
     */
    public function getImportante()
    {
        return $this->importante;
    }
}
