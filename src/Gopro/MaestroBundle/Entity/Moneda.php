<?php
namespace Gopro\MaestroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="mae_moneda")
 * @ORM\Entity
 */
class Moneda
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $codigoexterno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Tipocambio", mappedBy="moneda")
     */
    protected $tipocambios;

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

    public function __construct()
    {
        $this->tipocambios = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(is_null($this->getNombre())) {
            return sprintf("Id: %s.", $this->getId());
        }

        return $this->getNombre();
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
     * @return Moneda
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
     * Set codigo
     *
     * @param string $codigo
     * @return Moneda
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
     * Set creado
     *
     * @param \DateTime $creado
     * @return Moneda
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
     * @return Moneda
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
     * Set codigoexterno
     *
     * @param string $codigoexterno
     *
     * @return Moneda
     */
    public function setCodigoexterno($codigoexterno)
    {
        $this->codigoexterno = $codigoexterno;

        return $this;
    }

    /**
     * Get codigoexterno
     *
     * @return string
     */
    public function getCodigoexterno()
    {
        return $this->codigoexterno;
    }

    /**
     * Add tipocambio
     *
     * @param \Gopro\MaestroBundle\Entity\Tipocambio $tipocambio
     *
     * @return Moneda
     */
    public function addTipocambio(\Gopro\MaestroBundle\Entity\Tipocambio $tipocambio)
    {
        $this->tipocambios[] = $tipocambio;

        return $this;
    }

    /**
     * Remove tipocambio
     *
     * @param \Gopro\MaestroBundle\Entity\Tipocambio $tipocambio
     */
    public function removeTipocambio(\Gopro\MaestroBundle\Entity\Tipocambio $tipocambio)
    {
        $this->tipocambios->removeElement($tipocambio);
    }

    /**
     * Get tipocambios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipocambios()
    {
        return $this->tipocambios;
    }
}
