<?php

namespace Gopro\FitBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Medidaalimento
 *
 * @ORM\Table(name="fit_medidaalimento")
 * @ORM\Entity
 */
class Medidaalimento
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Gopro\FitBundle\Entity\Alimento", mappedBy="medidaalimento")
     */
    private $alimentos;

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
        $this->alimentos = new ArrayCollection();
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
     * @return Medidaalimento
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
     * Add alimento
     *
     * @param \Gopro\FitBundle\Entity\Alimento $alimento
     *
     * @return Medidaalimento
     */
    public function addAlimento(\Gopro\FitBundle\Entity\Alimento $alimento)
    {
        $alimento->setTipoalimento($this);

        $this->alimentos[] = $alimento;

        return $this;
    }

    /**
     * Remove alimento
     *
     * @param \Gopro\FitBundle\Entity\Alimento $alimento
     */
    public function removeDietaalimento(\Gopro\FitBundle\Entity\Alimento $alimento)
    {
        $this->alimentos->removeElement($alimento);
    }

    /**
     * Get alimento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietaalimentos()
    {
        return $this->alimentos;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Medidaalimento
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
     * @return Medidaalimento
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
