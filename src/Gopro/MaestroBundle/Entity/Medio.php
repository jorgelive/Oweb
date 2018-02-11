<?php

namespace Gopro\MaestroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gopro\CotizacionBundle\GoproCotizacionBundle;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

use Gopro\MainBundle\Traits\ArchivoTrait;


/**
 * Medio
 *
 * @ORM\Table(name="mae_medio")
 * @ORM\Entity(repositoryClass="Gopro\MaestroBundle\Repository\MedioRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\TranslationEntity(class="Gopro\MaestroBundle\Entity\MedioTranslation")
 */
class Medio implements TranslatableInterface
{
    use PersonalTranslatableTrait;

    use ArchivoTrait;

    private $path = '/carga/gopromaestro/medio';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @var \Gopro\MaestroBundle\Entity\Clasemedio
     *
     * @ORM\ManyToOne(targetEntity="Clasemedio", inversedBy="medios")
     * @ORM\JoinColumn(name="clasemedio_id", referencedColumnName="id", nullable=false)
     */
    protected $clasemedio;

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
     * @ORM\Column(type="datetime")
     */
    private $modificado;

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
     * Set clasemedio
     *
     * @param \Gopro\MaestroBundle\Entity\Clasemedio $clasemedio
     *
     * @return Medio
     */
    public function setClasemedio(\Gopro\MaestroBundle\Entity\Clasemedio $clasemedio = null)
    {
        $this->clasemedio = $clasemedio;

        return $this;
    }

    /**
     * Get clasemedio
     *
     * @return \Gopro\MaestroBundle\Entity\Clasemedio
     */
    public function getClasemedio()
    {
        return $this->clasemedio;
    }


    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return Medio
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
     * @return Medio
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
     * Set titulo.
     *
     * @param string $titulo
     *
     * @return Medio
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo.
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

}
