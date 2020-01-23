<?php

namespace Gopro\FitBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tipodieta
 *
 * @ORM\Table(name="fit_tipodieta")
 * @ORM\Entity
 */
class Tipodieta
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
     * @ORM\OneToMany(targetEntity="Gopro\FitBundle\Entity\Dieta", mappedBy="tipodieta")
     */
    private $dietas;

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
        $this->dietas = new ArrayCollection();
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
     * @return Tipodieta
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
     * Add dieta
     *
     * @param \Gopro\FitBundle\Entity\Dieta $dieta
     *
     * @return Tipodieta
     */
    public function addDieta(\Gopro\FitBundle\Entity\Dieta $dieta)
    {
        $dieta->setTipodieta($this);

        $this->dietas[] = $dieta;

        return $this;
    }

    /**
     * Remove dieta
     *
     * @param \Gopro\FitBundle\Entity\Dieta $dieta
     */
    public function removeDieta(\Gopro\FitBundle\Entity\Alimento $dieta)
    {
        $this->dietas->removeElement($dieta);
    }

    /**
     * Get alimento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDieta()
    {
        return $this->dietas;
    }



    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Tipodieta
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
     * @return Tipodieta
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
