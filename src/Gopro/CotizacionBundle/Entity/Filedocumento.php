<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gopro\CotizacionBundle\GoproCotizacionBundle;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Gopro\MainBundle\Traits\ArchivoTrait;

/**
 * Filedocumento
 *
 * @ORM\Table(name="cot_filedocumento")
 * @ORM\Entity(repositoryClass="Gopro\CotizacionBundle\Repository\FiledocumentoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Filedocumento
{
    use ArchivoTrait;

    private $path = '/carga/goprocotizacion/filedocumento';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
