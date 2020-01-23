<?php

namespace Gopro\FitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Alimento
 *
 * @ORM\Table(name="fit_alimento")
 * @ORM\Entity(repositoryClass="Gopro\FitBundle\Repository\AlimentoRepository")
 */
class Alimento
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
     * @ORM\Column(name="grasa", type="decimal", precision=7, scale=2)
     */
    private $grasa;

    /**
     * @var string
     *
     * @ORM\Column(name="carbohidrato", type="decimal", precision=7, scale=2)
     */
    private $carbohidrato;

    /**
     * @var string
     *
     * @ORM\Column(name="proteina", type="decimal", precision=7, scale=2)
     */
    private $proteina;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="decimal", precision=7, scale=2)
     */
    private $cantidad;

    /**
     * @var bool
     *
     * @ORM\Column(name="proteinaaltovalor", type="boolean", options={"default": 0})
     */
    private $proteinaaltovalor;

    /**
     * @var \Gopro\FitBundle\Entity\Tipoalimento
     *
     * @ORM\ManyToOne(targetEntity="Gopro\FitBundle\Entity\Tipoalimento", inversedBy="alimentos")
     * @ORM\JoinColumn(name="tipoalimento_id", referencedColumnName="id", nullable=false)
     */
    protected $tipoalimento;

    /**
     * @var \Gopro\FitBundle\Entity\Medidaalimento
     *
     * @ORM\ManyToOne(targetEntity="Gopro\FitBundle\Entity\Medidaalimento", inversedBy="alimentos")
     * @ORM\JoinColumn(name="mediaalimento_id", referencedColumnName="id", nullable=false)
     */
    protected $medidaalimento;

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

        if (empty($this->getMedidaalimento())) {
            return sprintf("Id: %s.", $this->getId());
        }

        return sprintf('%s (%s %s)', $this->getNombre(), $this->getCantidad(), $this->getMedidaalimento()->getNombre());
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
     * Set proteinaaltovalor
     *
     * @param boolean $proteinaaltovalor
     *
     * @return Alimento
     */
    public function setProteinaaltovalor($proteinaaltovalor)
    {
        $this->proteinaaltovalor = $proteinaaltovalor;
    
        return $this;
    }

    /**
     * Get proteinaaltovalor
     *
     * @return boolean
     */
    public function getProteinaaltovalor()
    {
        return $this->proteinaaltovalor;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Alimento
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
     * Set grasa
     *
     * @param string $grasa
     *
     * @return Alimento
     */
    public function setGrasa($grasa)
    {
        $this->grasa = $grasa;
    
        return $this;
    }

    /**
     * Get grasa
     *
     * @return string
     */
    public function getGrasa()
    {
        return $this->grasa;
    }

    /**
 * Set carbohidrato
 *
 * @param string $carbohidrato
 *
 * @return Alimento
 */
    public function setCarbohidrato($carbohidrato)
    {
        $this->carbohidrato = $carbohidrato;

        return $this;
    }

    /**
     * Get carbohidrato
     *
     * @return string
     */
    public function getCarbohidrato()
    {
        return $this->carbohidrato;
    }

    /**
     * Set proteina
     *
     * @param string $proteina
     *
     * @return Alimento
     */
    public function setProteina($proteina)
    {
        $this->proteina = $proteina;

        return $this;
    }

    /**
     * Get proteina
     *
     * @return string
     */
    public function getProteina()
    {
        return $this->proteina;
    }

    /**
     * Set cantidad
     *
     * @param string $cantidad
     *
     * @return Alimento
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Alimento
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
     * @return Alimento
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
     * Set tipoalimento
     *
     * @param \Gopro\FitBundle\Entity\Tipoalimento $tipoalimento
     *
     * @return Alimento
     */
    public function setTipoalimento(\Gopro\FitBundle\Entity\Tipoalimento $tipoalimento = null)
    {
        $this->tipoalimento = $tipoalimento;
    
        return $this;
    }

    /**
     * Get tipoalimento
     *
     * @return \Gopro\FitBundle\Entity\Tipoalimento
     */
    public function getTipoalimento()
    {
        return $this->tipoalimento;
    }

    /**
     * Set medidaalimento
     *
     * @param \Gopro\FitBundle\Entity\Medidaalimento $medidaalimento
     *
     * @return Alimento
     */
    public function setMedidaalimento(\Gopro\FitBundle\Entity\Medidaalimento $medidaalimento = null)
    {
        $this->medidaalimento = $medidaalimento;

        return $this;
    }

    /**
     * Get medidaalimento
     *
     * @return \Gopro\FitBundle\Entity\Medidaalimento
     */
    public function getMedidaalimento()
    {
        return $this->medidaalimento;
    }


}
