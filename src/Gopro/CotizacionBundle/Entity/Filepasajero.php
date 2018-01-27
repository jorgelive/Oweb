<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Filepasajero
 *
 * @ORM\Table(name="cot_filepasajero")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\FilepasajeroRepository")
 */
class Filepasajero
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var \Gopro\MaestroBundle\Entity\Pais
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Pais")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", nullable=false)
     */
    protected $pais;

    /**
     * @var \Gopro\MaestroBundle\Entity\Sexo
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Sexo")
     * @ORM\JoinColumn(name="sexo_id", referencedColumnName="id", nullable=false)
     */
    protected $sexo;

    /**
     * @var \Gopro\MaestroBundle\Entity\Tipodocumento
     *
     * @ORM\ManyToOne(targetEntity="Gopro\MaestroBundle\Entity\Tipodocumento")
     * @ORM\JoinColumn(name="tipodocumento_id", referencedColumnName="id", nullable=false)
     */
    protected $tipodocumento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanacimiento", type="date")
     */
    protected $fechanacimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="numerodocumento", type="string", length=100)
     */
    private $numerodocumento;

    /**
     * @var \Gopro\CotizacionBundle\Entity\File
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\File", inversedBy="filepasajeros")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     */
    protected $file;

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
        return sprintf('%s %s', $this->getNombre(), $this->getApellido());
    }




    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Filepasajero
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido.
     *
     * @param string $apellido
     *
     * @return Filepasajero
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido.
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fechanacimiento.
     *
     * @param \DateTime $fechanacimiento
     *
     * @return Filepasajero
     */
    public function setFechanacimiento($fechanacimiento)
    {
        $this->fechanacimiento = $fechanacimiento;
    
        return $this;
    }

    /**
     * Get fechanacimiento.
     *
     * @return \DateTime
     */
    public function getFechanacimiento()
    {
        return $this->fechanacimiento;
    }

    /**
     * Set numerodocumento.
     *
     * @param string $numerodocumento
     *
     * @return Filepasajero
     */
    public function setNumerodocumento($numerodocumento)
    {
        $this->numerodocumento = $numerodocumento;
    
        return $this;
    }

    /**
     * Get numerodocumento.
     *
     * @return string
     */
    public function getNumerodocumento()
    {
        return $this->numerodocumento;
    }

    /**
     * Set creado.
     *
     * @param \DateTime $creado
     *
     * @return Filepasajero
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;
    
        return $this;
    }

    /**
     * Get creado.
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set modificado.
     *
     * @param \DateTime $modificado
     *
     * @return Filepasajero
     */
    public function setModificado($modificado)
    {
        $this->modificado = $modificado;
    
        return $this;
    }

    /**
     * Get modificado.
     *
     * @return \DateTime
     */
    public function getModificado()
    {
        return $this->modificado;
    }

    /**
     * Set pais.
     *
     * @param \Gopro\MaestroBundle\Entity\Pais $pais
     *
     * @return Filepasajero
     */
    public function setPais(\Gopro\MaestroBundle\Entity\Pais $pais)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais.
     *
     * @return \Gopro\MaestroBundle\Entity\Pais
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set sexo.
     *
     * @param \Gopro\MaestroBundle\Entity\Sexo $sexo
     *
     * @return Filepasajero
     */
    public function setSexo(\Gopro\MaestroBundle\Entity\Sexo $sexo)
    {
        $this->sexo = $sexo;
    
        return $this;
    }

    /**
     * Get sexo.
     *
     * @return \Gopro\MaestroBundle\Entity\Sexo
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set tipodocumento.
     *
     * @param \Gopro\MaestroBundle\Entity\Tipodocumento $tipodocumento
     *
     * @return Filepasajero
     */
    public function setTipodocumento(\Gopro\MaestroBundle\Entity\Tipodocumento $tipodocumento)
    {
        $this->tipodocumento = $tipodocumento;
    
        return $this;
    }

    /**
     * Get tipodocumento.
     *
     * @return \Gopro\MaestroBundle\Entity\Tipodocumento
     */
    public function getTipodocumento()
    {
        return $this->tipodocumento;
    }

    /**
     * Set file.
     *
     * @param \Gopro\CotizacionBundle\Entity\File $file
     *
     * @return Filepasajero
     */
    public function setFile(\Gopro\CotizacionBundle\Entity\File $file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file.
     *
     * @return \Gopro\CotizacionBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set nacimiento.
     *
     * @param string $nacimiento
     *
     * @return Filepasajero
     */
    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;
    
        return $this;
    }

    /**
     * Get nacimiento.
     *
     * @return string
     */
    public function getNacimiento()
    {
        return $this->nacimiento;
    }
}
