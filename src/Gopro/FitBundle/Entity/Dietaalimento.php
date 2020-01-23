<?php

namespace Gopro\FitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Dietaalimento
 *
 * @ORM\Table(name="fit_dietaalimento")
 * @ORM\Entity(repositoryClass="Gopro\FitBundle\Repository\DietaalimentoRepository")
 */
class Dietaalimento
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
     * @ORM\Column(name="cantidad", type="decimal", precision=7, scale=2)
     */
    private $cantidad = '1';

    /**
     * @var \Gopro\FitBundle\Entity\Dietacomida
     *
     * @ORM\ManyToOne(targetEntity="Gopro\FitBundle\Entity\Dietacomida", inversedBy="dietaalimentos")
     * @ORM\JoinColumn(name="dietacomida_id", referencedColumnName="id", nullable=false)
     */
    protected $dietacomida;

    /**
     * @var \Gopro\FitBundle\Entity\Alimento
     *
     * @ORM\ManyToOne(targetEntity="Gopro\FitBundle\Entity\Alimento")
     * @ORM\JoinColumn(name="alimento_id", referencedColumnName="id", nullable=false)
     */
    protected $alimento;

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

        if(empty($this->getAlimento())){
            return sprintf("Id: %s.", $this->getId()) ?? '';
        }
        return $this->getAlimento()->getNombre();
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
            $this->setCreado(null);
            $this->setModificado(null);
        }
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
     * Set cantidad
     *
     * @param string $cantidad
     *
     * @return Dietaalimento
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

    public function getMedidaAlimento()
    {
        if (!empty($this->getAlimento())){
            return $this->getAlimento()->getMedidaalimento()->getNombre();
        }

        return "";
    }

    public function getCantidadAlimento()
    {
        if (!empty($this->getAlimento())){
            return $this->getAlimento()->getCantidad() * $this->getCantidad();
        }

        return "0";
    }

    public function getMedidaCantidadAlimento()
    {

        return sprintf('%s %s', $this->getCantidadAlimento(), $this->getMedidaAlimento());
    }


    public function getGrasa()
    {
        if (!empty($this->getAlimento())){
            return $this->getAlimento()->getGrasa();
        }

        return 0;

    }

    public function getGrasaTotal()
    {
        return $this->getGrasa() * $this->getCantidad();
    }

    public function getGrasaCalorias()
    {
        return $this->getGrasaTotal() * 9;
    }

    public function getCarbohidrato()
    {
        if (!empty($this->getAlimento())){
            return $this->getAlimento()->getCarbohidrato();
        }

        return 0;
    }

    public function getCarbohidratoTotal()
    {
        return $this->getCarbohidrato() * $this->getCantidad();
    }

    public function getCarbohidratoCalorias()
    {
        return $this->getCarbohidratoTotal() * 4;

    }

    public function getProteina()
    {
        if (!empty($this->getAlimento())){
            return $this->getAlimento()->getProteina();
        }
        return 0;

    }

    public function getProteinaTotal()
    {
        return $this->getProteina() * $this->getCantidad();
    }

    public function getProteinaTotalAlto()
    {
        if (empty($this->getAlimento()) || $this->getAlimento()->getProteinaaltovalor() === false){
            return 0;
        }
        return $this->getProteina() * $this->getCantidad();
    }

    public function getProteinaCalorias()
    {
        return $this->getProteinaTotal() * 4;
    }

    public function getTotalCalorias()
    {
        return $this->getGrasaCalorias() + $this->getCarbohidratoCalorias() + $this->getProteinaCalorias();
    }

    public function getEnergiaCalorias()
    {
        return $this->getGrasaCalorias() + $this->getCarbohidratoCalorias();
    }





    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Dietaalimento
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
     * @return Dietaalimento
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
     * Set dietacomida
     *
     * @param \Gopro\FitBundle\Entity\Dietacomida $dietacomida
     *
     * @return Dietaalimento
     */
    public function setDietacomida(\Gopro\FitBundle\Entity\Dietacomida $dietacomida = null)
    {
        $this->dietacomida = $dietacomida;
    
        return $this;
    }

    /**
     * Get dietacomida
     *
     * @return \Gopro\FitBundle\Entity\Dietacomida
     */
    public function getDietacomida()
    {
        return $this->dietacomida;
    }

    /**
     * Set alimento
     *
     * @param \Gopro\FitBundle\Entity\Alimento $alimento
     *
     * @return Dietaalimento
     */
    public function setAlimento(\Gopro\FitBundle\Entity\Alimento $alimento = null)
    {
        $this->alimento = $alimento;
    
        return $this;
    }

    /**
     * Get alimento
     *
     * @return \Gopro\FitBundle\Entity\Alimento
     */
    public function getAlimento()
    {
        return $this->alimento;
    }


}
