<?php

namespace Gopro\FitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Dietacomida
 *
 * @ORM\Table(name="fit_dietacomida")
 * @ORM\Entity(repositoryClass="Gopro\FitBundle\Repository\DietacomidaRepository")
 */
class Dietacomida
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
     * @var \Gopro\FitBundle\Entity\Dieta
     *
     * @ORM\ManyToOne(targetEntity="Gopro\FitBundle\Entity\Dieta", inversedBy="dietacomidas")
     * @ORM\JoinColumn(name="dieta_id", referencedColumnName="id", nullable=false)
     */
    protected $dieta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\FitBundle\Entity\Dietaalimento", mappedBy="dietacomida", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $dietaalimentos;

    /**
     * @var int
     *
     * @ORM\Column(name="numerocomida", type="integer", options={"default": 1})
     */
    private $numerocomida;

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
        $this->dietaalimentos = new ArrayCollection();
    }

    public function __clone() {
        if ($this->id) {
            $this->id = null;
            $this->setCreado(null);
            $this->setModificado(null);
            $newDietaalimentos = new ArrayCollection();
            foreach ($this->dietaalimentos as $dietaalimento) {
                $newDietaalimento = clone $dietaalimento;
                $newDietaalimento->setDietacomida($this);
                $newDietaalimentos->add($newDietaalimento);
            }
            $this->dietaalimentos = $newDietaalimentos;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(empty($this->getDieta())){
            return sprintf('id: %s', $this->getId());
        }

        return sprintf("%s : %s.", $this->getDieta()->getNombre(), $this->getId()) ?? sprintf("Id: %s.", $this->getId()) ?? '';

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
     * Set dieta
     *
     * @param \Gopro\FitBundle\Entity\Dieta $dieta
     *
     * @return Dietacomida
     */
    public function setDieta(\Gopro\FitBundle\Entity\Dieta $dieta= null)
    {
        $this->dieta = $dieta;
    
        return $this;
    }

    /**
     * Get dieta
     *
     * @return \Gopro\FitBundle\Entity\Dieta
     */
    public function getDieta()
    {
        return $this->dieta;
    }


    /**
     * Add dietaalimento
     *
     * @param \Gopro\FitBundle\Entity\Dietaalimento $dietaalimento
     *
     * @return Dietacomida
     */
    public function addDietaalimento(\Gopro\FitBundle\Entity\Dietaalimento $dietaalimento)
    {
        $dietaalimento->setDietacomida($this);

        $this->dietaalimentos[] = $dietaalimento;
    
        return $this;
    }

    /**
     * Remove dietaalimento
     *
     * @param \Gopro\FitBundle\Entity\Dietaalimento $dietaalimento
     */
    public function removeDietaalimento(\Gopro\FitBundle\Entity\Dietaalimento $dietaalimento)
    {
        $this->dietaalimentos->removeElement($dietaalimento);
    }

    /**
     * Get dietaalimentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietaalimentos()
    {
        return $this->dietaalimentos;
    }

    /**
     * Set numerocomida
     *
     * @param integer $numerocomida
     *
     * @return Dietacomida
     */
    public function setNumerocomida($numerocomida)
    {
        $this->numerocomida = $numerocomida;
    
        return $this;
    }

    /**
     * Get numerocomida
     *
     * @return integer
     */
    public function getNumerocomida()
    {
        return $this->numerocomida;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Dietacomida
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
     * @return Dietacomida
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
