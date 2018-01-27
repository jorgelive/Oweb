<?php

namespace Gopro\ServicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gopro\CotizacionBundle\GoproCotizacionBundle;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;


/**
 * Itidiaarchivo
 *
 * @ORM\Table(name="ser_itidiaarchivo")
 * @ORM\Entity(repositoryClass="Gopro\ServicioBundle\Repository\ItidiaarchivoRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\TranslationEntity(class="Gopro\ServicioBundle\Entity\ItidiaarchivoTranslation")
 */
class Itidiaarchivo implements TranslatableInterface
{
    use PersonalTranslatableTrait;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $extension;

    /**
     * @var \Gopro\ServicioBundle\Entity\Itinerariodia
     *
     * @ORM\ManyToOne(targetEntity="Gopro\ServicioBundle\Entity\Itinerariodia", inversedBy="itidiaarchivos")
     * @ORM\JoinColumn(name="itinerariodia_id", referencedColumnName="id", nullable=false)
     */
    protected $itinerariodia;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $archivo;

    /**
     * @var \DateTime $creado
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creado;

    /**
     * @var \DateTime $modificado
     * @Gedmo\Timestampable(on="update")
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
     * Sets archivo.
     *
     * @param UploadedFile $archivo
     */
    public function setArchivo(UploadedFile $archivo = null)
    {
        $this->archivo = $archivo;
        if (is_file($this->getAbsolutePath())) {
            $this->temp = $this->getAbsolutePath();
        } else {
            $this->extension = 'initial';
        }
    }

    /**
     * Get archivo.
     *
     * @return UploadedFile
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    private $temp;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        if (null !== $this->getArchivo()) {
            !empty($this->getArchivo()->guessExtension()) ? $this->extension = $this->getArchivo()->guessExtension() : $this->extension = $this->getArchivo()->getClientOriginalExtension();
            if(!$this->getNombre()){
                $this->nombre = preg_replace('/\.[^.]*$/', '', $this->getArchivo()->getClientOriginalName());
            }
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getArchivo()) {
            return;
        }
        if (isset($this->temp)) {
            unlink($this->temp);
            $this->temp = null;
        }
        $this->getArchivo()->move(
            $this->getUploadRootDir(),
            $this->id . '.' . $this->extension
        );

        $this->setArchivo(null);
    }

    /**
     * Para forzar los callbacks
     */
    public function refreshUpdated()
    {
        $this->setCreado(new \DateTime());
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->extension
            ? null
            : $this->getUploadRootDir() . '/' . $this->id . '.' . $this->extension;
    }

    public function getWebPath()
    {
        return null === $this->extension
            ? null
            : $this->getUploadDir() . '/' . $this->id . '.' . $this->extension;
    }

    public function getThumbPath()
    {
        if ($this->extension === null) {
            return null;
        }
        if (in_array($this->extension, ['jpg', 'jpeg', 'png', ''])) {
            return $this->getUploadDir() . '/thumb/' . $this->id . '.' . $this->extension;

        } else {
            return '/web/bundles/gopromain/images/iconos/' . $this->extension . '.png';
        }
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'web/carga/goprocotizacion/itidiaarchivo';
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
     * @return Itidiaarchivo
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
     * Set extension
     *
     * @param string $extension
     * @return Itidiaarchivo
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set itinerariodia
     *
     * @param \Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia
     *
     * @return Itidiaarchivo
     */
    public function setItinerariodia(\Gopro\ServicioBundle\Entity\Itinerariodia $itinerariodia = null)
    {
        $this->itinerariodia = $itinerariodia;

        return $this;
    }

    /**
     * Get itinerariodia
     *
     * @return \Gopro\ServicioBundle\Entity\Itinerariodia
     */
    public function getItinerariodia()
    {
        return $this->itinerariodia;
    }


    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return Itidiaarchivo
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
     * @return Itidiaarchivo
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
     * @return Itidiaarchivo
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
