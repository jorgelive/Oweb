<?php
namespace Gopro\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="tra_servicio")
 * @ORM\Entity(repositoryClass="Gopro\TransporteBundle\Repository\ServicioRepository")
 */
class Servicio
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Gopro\UserBundle\Entity\Dependencia
     *
     * @ORM\ManyToOne(targetEntity="Gopro\UserBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id", nullable=false)
     */
    protected $dependencia;

    /**
     * @var \Gopro\TransporteBundle\Entity\Unidad
     *
     * @ORM\ManyToOne(targetEntity="Unidad", inversedBy="servicios")
     * @ORM\JoinColumn(name="unidad_id", referencedColumnName="id", nullable=false)
     */
    protected $unidad;

    /**
     * @var \Gopro\TransporteBundle\Entity\Conductor
     *
     * @ORM\ManyToOne(targetEntity="Conductor", inversedBy="servicios")
     * @ORM\JoinColumn(name="conductor_id", referencedColumnName="id", nullable=false)
     */
    protected $conductor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciocontable", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciocontables;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechahorainicio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechahorafin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciocomponente", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciocomponentes;

    private $exportcomponentes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Serviciooperativo", mappedBy="servicio", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $serviciooperativos;

    private $exportoperativos;

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
        $this->serviciocomponentes = new ArrayCollection();
        $this->serviciocontables = new ArrayCollection();
        $this->serviciooperativos = new ArrayCollection();
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
            $this->setCreado(null);
            $this->setModificado(null);
            $newServiciocomponentes = new ArrayCollection();
            foreach ($this->serviciocomponentes as $serviciocomponente) {
                $newServiciocomponente = clone $serviciocomponente;
                $newServiciocomponente->setServicio($this);
                $newServiciocomponentes->add($newServiciocomponente);
            }
            $this->serviciocomponentes = $newServiciocomponentes;

            $newServiciooperativos = new ArrayCollection();
            foreach ($this->serviciooperativos as $serviciooperativo) {
                $newServiciooperativo = clone $serviciooperativo;
                $newServiciooperativo->setServicio($this);
                $newServiciooperativos->add($newServiciooperativo);
            }
            $this->serviciooperativos = $newServiciooperativos;

            $newServiciocontables = new ArrayCollection();
            foreach ($this->serviciocontables as $serviciocontable) {
                $newServiciocontable = clone $serviciocontable;
                $newServiciocontable->setServicio($this);
                $newServiciocontables->add($newServiciocontable);
            }
            $this->serviciocontables = $newServiciocontables;
        }
    }

    public function getExportcomponentes()
    {
        $exportcomponentes = [];
        foreach ($this->getServiciocomponentes() as $key => $serviciocomponente):
            if($serviciocomponente->getNumchd() > 0){
                $exportcomponentes[] = sprintf('%s %s x %s+%s de %s a %s', $serviciocomponente->getHora()->format('H:i'), $serviciocomponente->getNombre(), (string)$serviciocomponente->getNumadl(), (string)$serviciocomponente->getNumchd(), $serviciocomponente->getOrigen(), $serviciocomponente->getDestino());
            } else{
                $exportcomponentes[] = sprintf('%s %s x %s de %s a %s', $serviciocomponente->getHora()->format('H:i'), $serviciocomponente->getNombre(), (string)$serviciocomponente->getNumadl(), $serviciocomponente->getOrigen(), $serviciocomponente->getDestino());
            }
        endforeach;
        return $this->exportcomponentes = implode(', ', $exportcomponentes);
    }


    public function getExportoperativos()
    {

        $exportoperativos = [];
        foreach ($this->getServiciooperativos() as $key => $serviciooperativo):
            $exportoperativos[] =
                sprintf("%s: %s.", $serviciooperativo->getTiposeroperativo()->getCodigo(), $serviciooperativo->getTexto());
        endforeach;

        return $this->exportoperativos = implode(', ', $exportoperativos);
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
     * Get resumen
     *
     * @return string
     */
    public function getResumen()
    {
        $comp = [];

        foreach ($this->getServiciocomponentes() as $componente):
            $comp[] = sprintf('%s x %s', $componente->getNombre(), $componente->getNumadl());
        endforeach;

        $nombre = sprintf('%s [%s]', $this->getNombre(), implode(', ', $comp));

        if(!empty($this->getDependencia()) && !empty($this->getDependencia()->getOrganizacion())){
            $nombre .= sprintf(' (%s)', $this->getDependencia()->getOrganizacion()->getNombre());
        }

        $resumenArray[] = $nombre;

        if(!empty($this->getUnidad())){
            $resumenArray[] = 'U:' . $this->getUnidad()->getAbreviatura();
        }

        if(!empty($this->getConductor())){
            $resumenArray[] = 'C:' . $this->getConductor()->getAbreviatura();
        }

        return implode(', ' , $resumenArray);
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
     * Set dependencia
     *
     * @param \Gopro\UserBundle\Entity\Dependencia $dependencia
     *
     * @return Servicio
     */
    public function setDependencia(\Gopro\UserBundle\Entity\Dependencia $dependencia = null)
    {
        $this->dependencia = $dependencia;

        return $this;
    }

    /**
     * Get dependencia
     *
     * @return \Gopro\UserBundle\Entity\Dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * Set unidad
     *
     * @param \Gopro\TransporteBundle\Entity\Unidad $unidad
     *
     * @return Servicio
     */
    public function setUnidad(\Gopro\TransporteBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \Gopro\TransporteBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set conductor
     *
     * @param \Gopro\TransporteBundle\Entity\Conductor $conductor
     *
     * @return Servicio
     */
    public function setConductor(\Gopro\TransporteBundle\Entity\Conductor $conductor = null)
    {
        $this->conductor = $conductor;

        return $this;
    }

    /**
     * Get conductor
     *
     * @return \Gopro\TransporteBundle\Entity\Conductor
     */
    public function getConductor()
    {
        return $this->conductor;
    }

    /**
     * Add serviciocomponente
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocomponente $serviciocomponente
     *
     * @return Servicio
     */
    public function addServiciocomponente(\Gopro\TransporteBundle\Entity\Serviciocomponente $serviciocomponente)
    {
        $serviciocomponente->setServicio($this);

        $this->serviciocomponentes[] = $serviciocomponente;

        return $this;
    }

    /**
     * Remove serviciocomponente
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocomponente $serviciocomponente
     */
    public function removeServiciocomponente(\Gopro\TransporteBundle\Entity\Serviciocomponente $serviciocomponente)
    {
        $this->serviciocomponentes->removeElement($serviciocomponente);
    }

    /**
     * Get serviciocomponentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciocomponentes()
    {
        return $this->serviciocomponentes;
    }

    /**
     * Add serviciocontable
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     *
     * @return Servicio
     */
    public function addServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable)
    {
        $serviciocontable->setServicio($this);

        $this->serviciocontables[] = $serviciocontable;

        return $this;
    }

    /**
     * Remove serviciocontable
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable
     */
    public function removeServiciocontable(\Gopro\TransporteBundle\Entity\Serviciocontable $serviciocontable)
    {
        $this->serviciocontables->removeElement($serviciocontable);
    }

    /**
     * Get serviciocontables
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciocontables()
    {
        return $this->serviciocontables;
    }

    /**
     * Add serviciooperativo
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo
     *
     * @return Servicio
     */
    public function addServiciooperativo(\Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo)
    {
        $serviciooperativo->setServicio($this);

        $this->serviciooperativos[] = $serviciooperativo;

        return $this;
    }

    /**
     * Remove serviciooperativo
     *
     * @param \Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo
     */
    public function removeServiciooperativo(\Gopro\TransporteBundle\Entity\Serviciooperativo $serviciooperativo)
    {
        $this->serviciooperativos->removeElement($serviciooperativo);
    }

    /**
     * Get serviciooperativos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiciooperativos()
    {
        return $this->serviciooperativos;
    }


    /**
     * Set fechahorainicio
     *
     * @param \DateTime $fechahorainicio
     *
     * @return Servicio
     */
    public function setFechahorainicio($fechahorainicio)
    {
        $this->fechahorainicio = $fechahorainicio;

        return $this;
    }

    /**
     * Get fechahorainicio
     *
     * @return \DateTime
     */
    public function getFechahorainicio()
    {
        return $this->fechahorainicio;
    }

    /**
     * Set fechahorafin
     *
     * @param \DateTime $fechahorafin
     *
     * @return Servicio
     */
    public function setFechahorafin($fechahorafin)
    {
        if(empty($fechahorafin) && $this->fechahorainicio instanceof \DateTime){
            $fechahorafin = clone $this->fechahorainicio;
            $fechahorafin->add(new \DateInterval('PT1H'));
        }

        $this->fechahorafin = $fechahorafin;

        return $this;

    }

    /**
     * Get fechahorafin
     *
     * @return \DateTime
     */
    public function getFechahorafin()
    {
        return $this->fechahorafin;
    }
}
