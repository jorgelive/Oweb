<?php

namespace Gopro\CuentaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Movimiento
 *
 * @ORM\Table(name="cue_movimiento")
 * @ORM\Entity(repositoryClass="Gopro\CuentaBundle\Repository\MovimientoRepository")
 */
class Movimiento
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
     * @var \Gopro\CuentaBundle\Entity\Periodo
     *
     * @ORM\ManyToOne(targetEntity="Periodo", inversedBy="movimientos")
     * @ORM\JoinColumn(name="periodo_id", referencedColumnName="id", nullable=false)
     */
    protected $periodo;

    /**
     * @var \Gopro\CuentaBundle\Entity\Periodo
     *
     * @ORM\ManyToOne(targetEntity="Periodo")
     * @ORM\JoinColumn(name="periodotransferencia_id", referencedColumnName="id", nullable=true)
     * @ORM\OrderBy({"modificado" = "ASC"})
     */
    protected $periodotransferencia;

    /**
     * @var \Gopro\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Gopro\UserBundle\Entity\User", inversedBy="movimientos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var \Gopro\CuentaBundle\Entity\Centro
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CuentaBundle\Entity\Centro", inversedBy="movimientos")
     * @ORM\JoinColumn(name="centro_id", referencedColumnName="id", nullable=true)
     */
    protected $centro;

    /**
     * @var \Gopro\CuentaBundle\Entity\Clase
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CuentaBundle\Entity\Clase", inversedBy="movimientos")
     * @ORM\JoinColumn(name="clase_id", referencedColumnName="id", nullable=false)
     */
    protected $clase;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechahora", type="datetime")
     */
    private $fechahora;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="cobradorpagador", type="string", length=255, nullable=true)
     */
    private $cobradorpagador;

    /**
     * @var string
     *
     * @ORM\Column(name="debe", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $debe;

    /**
     * @var string
     *
     * @ORM\Column(name="haber", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $haber;

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

    public function __toString()
    {
        return $this->getDescripcion() ?? sprintf("Id: %s.", $this->getId()) ?? '';
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
     * Set fechahora.
     *
     * @param \DateTime $fechahora
     *
     * @return Movimiento
     */
    public function setFechahora($fechahora)
    {
        $this->fechahora = $fechahora;
    
        return $this;
    }

    /**
     * Get fechahora.
     *
     * @return \DateTime
     */
    public function getFechahora()
    {
        return $this->fechahora;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return Movimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set cobradorpagador.
     *
     * @param string $cobradorpagador
     *
     * @return Movimiento
     */
    public function setCobradorpagador($cobradorpagador = null)
    {
        $this->cobradorpagador = $cobradorpagador;

        return $this;
    }

    /**
     * Get cobradorpagador.
     *
     * @return string
     */
    public function getCobradorpagador()
    {
        return $this->cobradorpagador;
    }

    /**
     * Set debe.
     *
     * @param string $debe
     *
     * @return Movimiento
     */
    public function setDebe($debe)
    {
        $this->debe = $debe;
    
        return $this;
    }

    /**
     * Get debe.
     *
     * @return string
     */
    public function getDebe()
    {
        return $this->debe;
    }

    /**
     * Set haber.
     *
     * @param string $haber
     *
     * @return Movimiento
     */
    public function setHaber($haber)
    {
        $this->haber = $haber;
    
        return $this;
    }

    /**
     * Get haber.
     *
     * @return string
     */
    public function getHaber()
    {
        return $this->haber;
    }

    /**
     * Set creado.
     *
     * @param \DateTime $creado
     *
     * @return Movimiento
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
     * @return Movimiento
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
     * Set periodo.
     *
     * @param \Gopro\CuentaBundle\Entity\Periodo $periodo
     *
     * @return Movimiento
     */
    public function setPeriodo(\Gopro\CuentaBundle\Entity\Periodo $periodo)
    {
        $this->periodo = $periodo;
    
        return $this;
    }

    /**
     * Get periodo.
     *
     * @return \Gopro\CuentaBundle\Entity\Periodo
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set user.
     *
     * @param \Gopro\UserBundle\Entity\User $user
     *
     * @return Movimiento
     */
    public function setUser(\Gopro\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user.
     *
     * @return \Gopro\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set clase.
     *
     * @param \Gopro\CuentaBundle\Entity\Clase $clase
     *
     * @return Movimiento
     */
    public function setClase(\Gopro\CuentaBundle\Entity\Clase $clase)
    {
        $this->clase = $clase;
    
        return $this;
    }

    /**
     * Get clase.
     *
     * @return \Gopro\CuentaBundle\Entity\Clase
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set centro.
     *
     * @param \Gopro\CuentaBundle\Entity\Centro $centro
     *
     * @return Movimiento
     */
    public function setCentro(\Gopro\CuentaBundle\Entity\Centro $centro = null)
    {
        $this->centro = $centro;
    
        return $this;
    }

    /**
     * Get centro.
     *
     * @return \Gopro\CuentaBundle\Entity\Centro
     */
    public function getCentro()
    {
        return $this->centro;
    }

    /**
     * Set periodotransferencia.
     *
     * @param \Gopro\CuentaBundle\Entity\Periodo|null $periodotransferencia
     *
     * @return Movimiento
     */
    public function setPeriodotransferencia(\Gopro\CuentaBundle\Entity\Periodo $periodotransferencia = null)
    {
        $this->periodotransferencia = $periodotransferencia;
    
        return $this;
    }

    /**
     * Get periodotransferencia.
     *
     * @return \Gopro\CuentaBundle\Entity\Periodo|null
     */
    public function getPeriodotransferencia()
    {
        return $this->periodotransferencia;
    }
}
