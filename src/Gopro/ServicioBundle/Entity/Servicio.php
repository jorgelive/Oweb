<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * Servicio
 *
 * @ORM\Table(name="ser_servicio")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\ServicioRepository")
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\ServicioTranslation")
 */
class Servicio implements TranslatableInterface
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
     * @ORM\Column(name="codigo", type="string", length=20)
     */
    private $codigo;

    /**
     * @var bool
     *
     * @ORM\Column(name="paralelo", type="boolean", options={"default": 0})
     */
    private $paralelo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

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
     * @ORM\ManyToMany(targetEntity="Gopro\ServicioBundle\Entity\Componente", inversedBy="servicios")
     */
    private $componentes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\ServicioBundle\Entity\Itinerario", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $itinerarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentes = new ArrayCollection();
        $this->itinerarios = new ArrayCollection();
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Servicio
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Servicio
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
     * @return Servicio
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
     * @return Servicio
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
     * Add componente
     *
     * @param \Gopro\ServicioBundle\Entity\Componente $componente
     *
     * @return Servicio
     */
    public function addComponente(\Gopro\ServicioBundle\Entity\Componente $componente)
    {
        //notajg: no setear el componente ni uilizar by_reference = false en el admin

        $this->componentes[] = $componente;
    
        return $this;
    }

    /**
     * Remove componente
     *
     * @param \Gopro\ServicioBundle\Entity\Componente $componente
     */
    public function removeComponente(\Gopro\ServicioBundle\Entity\Componente $componente)
    {
        $this->componentes->removeElement($componente);
    }

    /**
     * Get componentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponentes()
    {
        return $this->componentes;
    }

    /**
     * Add itinerario
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerario $itinerario
     *
     * @return Servicio
     */
    public function addItinerario(\Gopro\ServicioBundle\Entity\Itinerario $itinerario)
    {
        $itinerario->setServicio($this);

        $this->itinerarios[] = $itinerario;
    
        return $this;
    }

    /**
     * Remove itinerario
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerario $itinerario
     */
    public function removeItinerario(\Gopro\ServicioBundle\Entity\Itinerario $itinerario)
    {
        $this->itinerarios->removeElement($itinerario);
    }

    /**
     * Get itinerarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItinerarios()
    {
        return $this->itinerarios;
    }

    /**
     * Set paralelo.
     *
     * @param bool $paralelo
     *
     * @return Servicio
     */
    public function setParalelo($paralelo)
    {
        $this->paralelo = $paralelo;
    
        return $this;
    }

    /**
     * Get paralelo.
     *
     * @return bool
     */
    public function getParalelo()
    {
        return $this->paralelo;
    }
}
