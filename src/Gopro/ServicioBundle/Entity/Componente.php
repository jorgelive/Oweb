<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * Componente
 *
 * @ORM\Table(name="ser_componente")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\ComponenteRepository")
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\ComponenteTranslation")
 */
class Componente implements TranslatableInterface
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
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="titulo", type="string", length=150, nullable=true)
     */
    private $titulo;

    /**
     * @var \Gopro\ServicioBundle\Entity\Servicio
     *
     * @ORM\ManyToMany(targetEntity="Gopro\ServicioBundle\Entity\Servicio", mappedBy="componentes")
     */
    protected $servicios;

    /**
     * @var \Gopro\ServicioBundle\Entity\Tipocomponente
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Tipocomponente")
     * @ORM\JoinColumn(name="tipocomponente_id", referencedColumnName="id", nullable=false)
     */
    protected $tipocomponente;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion", type="decimal", precision=4, scale=1, nullable=true)
     */
    private $duracion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\ServicioBundle\Entity\Tarifa", mappedBy="componente", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $tarifas;

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
     * Constructor
     */
    public function __construct()
    {
        $this->tarifas = new ArrayCollection();
        $this->servicios = new ArrayCollection();
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
     * @return Componente
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Componente
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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Componente
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
     * @return Componente
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
     * Set tipocomponente
     *
     * @param \Gopro\ServicioBundle\Entity\Tipocomponente $tipocomponente
     *
     * @return Componente
     */
    public function setTipocomponente(\Gopro\ServicioBundle\Entity\Tipocomponente $tipocomponente = null)
    {
        $this->tipocomponente = $tipocomponente;
    
        return $this;
    }

    /**
     * Get tipocomponente
     *
     * @return \Gopro\ServicioBundle\Entity\Tipocomponente
     */
    public function getTipocomponente()
    {
        return $this->tipocomponente;
    }

    /**
     * Add tarifa
     *
     * @param \Gopro\ServicioBundle\Entity\Tarifa $tarifa
     *
     * @return Componente
     */
    public function addTarifa(\Gopro\ServicioBundle\Entity\Tarifa $tarifa)
    {
        $tarifa->setComponente($this);

        $this->tarifas[] = $tarifa;
    
        return $this;
    }

    /**
     * Remove tarifa
     *
     * @param \Gopro\ServicioBundle\Entity\Tarifa $tarifa
     */
    public function removeTarifa(\Gopro\ServicioBundle\Entity\Tarifa $tarifa)
    {
        $this->tarifas->removeElement($tarifa);
    }

    /**
     * Get tarifas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTarifas()
    {
        return $this->tarifas;
    }

    /**
     * Add servicio
     *
     * @param \Gopro\ServicioBundle\Entity\Servicio $servicio
     *
     * @return Componente
     */
    public function addServicio(\Gopro\ServicioBundle\Entity\Servicio $servicio)
    {
        $servicio->addComponente($this);

        $this->servicios[] = $servicio;
    
        return $this;
    }

    /**
     * Remove servicio
     *
     * @param \Gopro\ServicioBundle\Entity\Servicio $servicio
     */
    public function removeServicio(\Gopro\ServicioBundle\Entity\Servicio $servicio)
    {
        $this->servicios->removeElement($servicio);
        $servicio->removeComponente($this);
    }

    /**
     * Get servicios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServicios()
    {
        return $this->servicios;
    }

    /**
     * Set duracion.
     *
     * @param string|null $duracion
     *
     * @return Componente
     */
    public function setDuracion($duracion = null)
    {
        $this->duracion = $duracion;
    
        return $this;
    }

    /**
     * Get duracion.
     *
     * @return string|null
     */
    public function getDuracion()
    {
        return $this->duracion;
    }
}
