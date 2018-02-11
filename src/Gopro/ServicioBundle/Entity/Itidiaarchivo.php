<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gopro\CotizacionBundle\GoproCotizacionBundle;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Gopro\MainBundle\Traits\ArchivoTrait;


/**
 * Itidiaarchivo
 *
 * @ORM\Table(name="ser_itidiaarchivo")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\ItidiaarchivoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Itidiaarchivo
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\ServicioBundle\Entity\Itinerariodia
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Itinerariodia", inversedBy="itidiaarchivos")
     * @ORM\JoinColumn(name="itinerariodia_id", referencedColumnName="id", nullable=false)
     */
    protected $itinerariodia;

    /**
     * @var \Gopro\MaestroBundle\Entity\Medio
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Medio")
     * @ORM\JoinColumn(name="medio_id", referencedColumnName="id", nullable=false)
     */
    private $medio;

    /**
     * @var int
     *
     * @ORM\Column(name="prioridad", type="integer", nullable=true)
     */
    private $prioridad;

    /**
     * @var \DateTime $creado
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creado;

    /**
     * @var \DateTime $modificado
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $modificado;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMedio()->getNombre() ?? sprintf("Id: %s.", $this->getId()) ?? '';
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
     * Set itinerariodia
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia
     *
     * @return Itidiaarchivo
     */
    public function setItinerariodia(\Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia = null)
    {
        $this->itinerariodia = $itinerariodia;

        return $this;
    }

    /**
     * Get itinerariodia
     *
     * @return \Gopro\ServicioBundle\Entity\Itinerariodia
     */
    public function getItinerariodia()
    {
        return $this->itinerariodia;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return Itidiaarchivo
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
     * @return Itidiaarchivo
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
     * Set prioridad.
     *
     * @param int|null $prioridad
     *
     * @return Itidiaarchivo
     */
    public function setPrioridad($prioridad = null)
    {
        $this->prioridad = $prioridad;
    
        return $this;
    }

    /**
     * Get prioridad.
     *
     * @return int|null
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set medio.
     *
     * @param \Gopro\MaestroBundle\Entity\Medio|null $medio
     *
     * @return Itidiaarchivo
     */
    public function setMedio(\Gopro\MaestroBundle\Entity\Medio $medio = null)
    {
        $this->medio = $medio;
    
        return $this;
    }

    /**
     * Get medio.
     *
     * @return \Gopro\MaestroBundle\Entity\Medio|null
     */
    public function getMedio()
    {
        return $this->medio;
    }
}
