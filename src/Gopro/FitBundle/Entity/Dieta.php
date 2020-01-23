<?php

namespace Gopro\FitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * Dieta
 *
 * @ORM\Table(name="fit_dieta")
 * @ORM\Entity(repositoryClass="Gopro\FitBundle\Repository\DietaRepository")
 */
class Dieta
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
     * @var string
     *
     * @ORM\Column(name="peso", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $peso = '60.00';

    /**
     * @var string
     *
     * @ORM\Column(name="indicedegrasa", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $indicedegrasa = '20.00';

    /**
     * @var \Gopro\FitBundle\Entity\Tipodieta
     *
     * @ORM\ManyToOne(targetEntity="Gopro\FitBundle\Entity\Tipodieta" , inversedBy="dietas")
     * @ORM\JoinColumn(name="tipodieta_id", referencedColumnName="id", nullable=false)
     */
    protected $tipodieta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\FitBundle\Entity\Dietacomida", mappedBy="dieta", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $dietacomidas;

    /**
     * @var \Gopro\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Gopro\UserBundle\Entity\User" )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

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
        $this->dietacomidas = new ArrayCollection();
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
            $this->setCreado(null);
            $this->setModificado(null);
            $newDietacomidas = new ArrayCollection();
            foreach ($this->dietacomidas as $dietacomida) {
                $newDietacomida = clone $dietacomida;
                $newDietacomida->setDieta($this);
                $newDietacomidas->add($newDietacomida);
            }
            $this->dietacomidas = $newDietacomidas;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(empty($this->getUser())){
            return $this->getNombre() ?? sprintf("Id: %s.", $this->getId()) ?? '';
        }


        return sprintf("%s : %s.", $this->getUser()->getFullname(), $this->getNombre()) ?? sprintf("Id: %s.", $this->getId()) ?? '';
    }

    public function getGrasaCalorias()
    {
        $result = 0;
        foreach ($this->dietacomidas as $dietacomida):
            $result += $dietacomida->getGrasaCalorias();
        endforeach;

        return $result;
    }

    public function getCarbohidratoCalorias()
    {
        $result = 0;
        foreach ($this->dietacomidas as $dietacomida):
            $result += $dietacomida->getCarbohidratoCalorias();
        endforeach;

        return $result;
    }

    public function getProteinaCalorias()
    {
        $result = 0;
        foreach ($this->dietacomidas as $dietacomida):
            $result += $dietacomida->getProteinaCalorias();
        endforeach;

        return $result;
    }

    public function getTotalCalorias()
    {
        $result = $this->getGrasaCalorias() + $this->getCarbohidratoCalorias() + $this->getProteinaCalorias();

        return $result;
    }

    public function getEnergiaCalorias()
    {
        $result = $this->getGrasaCalorias() + $this->getCarbohidratoCalorias();

        return $result;
    }

    public function getGrasaPorcentaje()
    {
        if (empty($this->getTotalCalorias())){return 0;}

        $result = $this->getGrasaCalorias() / $this->getTotalCalorias() * 100;

        return round($result, 2);
    }

    public function getCarbohidratoPorcentaje()
    {
        if (empty($this->getTotalCalorias())){return 0;}

        $result = $this->getCarbohidratoCalorias() / $this->getTotalCalorias() * 100;

        return round($result, 2);
    }

    public function getProteinaPorcentaje()
    {
        if (empty($this->getTotalCalorias())){return 0;}

        $result = $this->getProteinaCalorias() / $this->getTotalCalorias() * 100;

        return round($result, 2);
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
     * @return Dieta
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
     * Set tipodieta
     *
     * @param \Gopro\FitBundle\Entity\Tipodieta $tipodieta
     *
     * @return Dieta
     */
    public function setTipodieta(\Gopro\FitBundle\Entity\Tipodieta $tipodieta)
    {
        $this->tipodieta = $tipodieta;
    
        return $this;
    }

    /**
     * Get tipodieta
     *
     * @return \Gopro\FitBundle\Entity\Tipodieta
     */
    public function getTipodieta()
    {
        return $this->tipodieta;
    }

    /**
     * Add dietacomida
     *
     * @param \Gopro\FitBundle\Entity\Dietacomida $dietacomida
     *
     * @return Dieta
     */
    public function addDietacomida(\Gopro\FitBundle\Entity\Dietacomida $dietacomida)
    {
        $dietacomida->setDieta($this);

        $this->dietacomidas[] = $dietacomida;
    
        return $this;
    }

    /**
     * Remove dietacomida
     *
     * @param \Gopro\FitBundle\Entity\Dietacomida $dietacomida
     */
    public function removeDietacomida(\Gopro\FitBundle\Entity\Dietacomida $dietacomida)
    {
        $this->dietacomidas->removeElement($dietacomida);
    }

    /**
     * Get dietacomidas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietacomidas()
    {
        return $this->dietacomidas;
    }

    /**
     * Set peso.
     *
     * @param string $peso
     *
     * @return Dieta
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    
        return $this;
    }

    /**
     * Get peso.
     *
     * @return string
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set indicedegrasa.
     *
     * @param string $indicedegrasa
     *
     * @return Dieta
     */
    public function setIndicedegrasa($indicedegrasa)
    {
        $this->indicedegrasa= $indicedegrasa;

        return $this;
    }

    /**
     * Get indicedegrasa.
     *
     * @return string
     */
    public function getIndicedegrasa()
    {
        return $this->indicedegrasa;
    }

    /**
     * Set user
     *
     * @param \Gopro\UserBundle\Entity\User $user
     *
     * @return Dieta
     */
    public function setUser(\Gopro\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Gopro\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Dieta
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Dieta
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
     * @return Dieta
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


}
