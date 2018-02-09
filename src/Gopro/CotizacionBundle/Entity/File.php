<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * File
 *
 * @ORM\Table(name="cot_file")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\FileRepository")
 */
class File
{
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
     * @var \Gopro\MaestroBundle\Entity\Pais
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Pais")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", nullable=false)
     */
    protected $pais;

    /**
     * @var \Gopro\MaestroBundle\Entity\Idioma
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Idioma")
     * @ORM\JoinColumn(name="idioma_id", referencedColumnName="id", nullable=false)
     */
    protected $idioma;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Cotizacion", mappedBy="file", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $cotizaciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Filedocumento", mappedBy="file", cascade={"persist","remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"prioridad" = "ASC"})
     */
    private $filedocumentos;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\CotizacionBundle\Entity\Filepasajero", mappedBy="file", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $filepasajeros;

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
        $this->filepasajeros = new ArrayCollection();
        $this->filedocumentos = new ArrayCollection();
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
     * @return File
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
     * Set pais
     *
     * @param \Gopro\MaestroBundle\Entity\Pais $pais
     *
     * @return File
     */
    public function setPais(\Gopro\MaestroBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \Gopro\MaestroBundle\Entity\Pais
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return File
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
     * @return File
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
     * @return File
     */
    public function addCotizacion(\Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion)
    {
        $cotizacion->setFile($this);

        $this->cotizaciones[] = $cotizacion;
    
        return $this;
    }


    /**
     * Add cotizacione por inflector ingles
     *
     * @param \Gopro\CotizacionBundle\Entity\Cotizacion $cotizacion
     *
     * @return File
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
     * Set idioma.
     *
     * @param \Gopro\MaestroBundle\Entity\Idioma|null $idioma
     *
     * @return File
     */
    public function setIdioma(\Gopro\MaestroBundle\Entity\Idioma $idioma = null)
    {
        $this->idioma = $idioma;
    
        return $this;
    }

    /**
     * Get idioma.
     *
     * @return \Gopro\MaestroBundle\Entity\Idioma|null
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Add filepasajero.
     *
     * @param \Gopro\CotizacionBundle\Entity\Filepasajero $filepasajero
     *
     * @return File
     */
    public function addFilepasajero(\Gopro\CotizacionBundle\Entity\Filepasajero $filepasajero)
    {
        $filepasajero->setFile($this);

        $this->filepasajeros[] = $filepasajero;
    
        return $this;
    }

    /**
     * Remove filepasajero.
     *
     * @param \Gopro\CotizacionBundle\Entity\Filepasajero $filepasajero
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFilepasajero(\Gopro\CotizacionBundle\Entity\Filepasajero $filepasajero)
    {
        return $this->filepasajeros->removeElement($filepasajero);
    }

    /**
     * Get filepasajeros.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilepasajeros()
    {
        return $this->filepasajeros;
    }

    /**
     * Add filedocumento.
     *
     * @param \Gopro\CotizacionBundle\Entity\Filedocumento $filedocumento
     *
     * @return File
     */
    public function addFiledocumento(\Gopro\CotizacionBundle\Entity\Filedocumento $filedocumento)
    {
        $filedocumento->setFile($this);

        $this->filedocumentos[] = $filedocumento;
    
        return $this;
    }

    /**
     * Remove filedocumento.
     *
     * @param \Gopro\CotizacionBundle\Entity\Filedocumento $filedocumento
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFiledocumento(\Gopro\CotizacionBundle\Entity\Filedocumento $filedocumento)
    {
        return $this->filedocumentos->removeElement($filedocumento);
    }

    /**
     * Get filedocumentos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiledocumentos()
    {
        return $this->filedocumentos;
    }
}
