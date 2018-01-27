<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gopro\CotizacionBundle\GoproCotizacionBundle;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Filedocumento
 *
 * @ORM\Table(name="cot_filedocumento")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\FiledocumentoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Filedocumento
{
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
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $extension;

    /**
     * @var \Gopro\CotizacionBundle\Entity\Tipofiledocumento
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\Tipofiledocumento")
     * @ORM\JoinColumn(name="tipofiledocumento_id", referencedColumnName="id", nullable=false)
     */
    private $tipofiledocumento;

    /**
     * @var \Gopro\CotizacionBundle\Entity\File
     *
     * @ORM\ManyToOne(targetEntity="Gopro\CotizacionBundle\Entity\File", inversedBy="filedocumentos")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     */
    protected $file;

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
        return 'web/carga/goprocotizacion/filedocumento';
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
     * @return Filedocumento
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
     * @return Filedocumento
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
     * Set tipocotsocumento
     *
     * @param \Gopro\CotizacionBundle\Entity\Tipofiledocumento $tipofiledocumento
     * @return Filedocumento
     */
    public function setTipofiledocumento(\Gopro\CotizacionBundle\Entity\Tipofiledocumento $tipofiledocumento)
    {
        $this->tipofiledocumento = $tipofiledocumento;

        return $this;
    }

    /**
     * Get tipofiledocumento
     *
     * @return \Gopro\CotizacionBundle\Entity\Tipofiledocumento
     */
    public function getTipofiledocumento()
    {
        return $this->tipofiledocumento;
    }

    /**
     * Set file
     *
     * @param \Gopro\CotizacionBundle\Entity\File $file
     *
     * @return Filedocumento
     */
    public function setFile(\Gopro\CotizacionBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \Gopro\CotizacionBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Set creado
     *
     * @param \DateTime $creado
     * @return Filedocumento
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
     * @return Filedocumento
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
