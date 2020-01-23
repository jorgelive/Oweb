<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Itinerario
 *
 * @ORM\Table(name="ser_itinerario")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\ItinerarioRepository")
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\ItinerarioTranslation")
 */
class Itinerario implements TranslatableInterface
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion", type="decimal", precision=4, scale=1)
     */
    private $duracion;

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
     * @var \Gopro\ServicioBundle\Entity\Servicio
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Servicio", inversedBy="itinerarios")
     * @ORM\JoinColumn(name="servicio_id", referencedColumnName="id", nullable=false)
     */
    protected $servicio;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\ServicioBundle\Entity\Itinerariodia", mappedBy="itinerario", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $itinerariodias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itinerariodias = new ArrayCollection();
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
     * @return Itinerario
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
     * @return Itinerario
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
     * @return Itinerario
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
     * @param \Gopro\ServicioBundle\Entity\Servicio $servicio
     *
     * @return Itinerario
     */
    public function setServicio(\Gopro\ServicioBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;
    
        return $this;
    }

    /**
     * Get servicio
     *
     * @return \Gopro\ServicioBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Add itinerariodia
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia
     *
     * @return Itinerario
     */
    public function addItinerariodia(\Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia)
    {
        $itinerariodia->setItinerario($this);

        $this->itinerariodias[] = $itinerariodia;
    
        return $this;
    }

    /**
     * Remove itinerariodia
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia
     */
    public function removeItinerariodia(\Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia)
    {
        $this->itinerariodias->removeElement($itinerariodia);
    }

    /**
     * Get itinerariodias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItinerariodias()
    {
        return $this->itinerariodias;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return Itinerario
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    
        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set duracion
     *
     * @param string $duracion
     *
     * @return Itinerario
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    
        return $this;
    }

    /**
     * Get duracion
     *
     * @return string
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

}
