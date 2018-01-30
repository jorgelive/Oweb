<?php

namespace Gopro\MainBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Archivo trait.
 *
 */
trait ArchivoTrait
{


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $archivo;

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
            $this->id.'.'.$this->extension
        );

        $this->setArchivo(null);
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
            : $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
    }

    public function getWebPath()
    {
        return null === $this->extension
            ? null
            : $this->getUploadDir() . '/'.$this->id.'.'.$this->extension;
    }

    public function getThumbPath()
    {
        if($this->extension===null){
            return null;
        }
        if(in_array($this->extension,['jpg','jpeg','png',''])){
            return $this->getUploadDir() . '/thumb/'.$this->id.'.'.$this->extension;

        }else{
            return '/bundles/gopromain/images/iconos/'.$this->extension.'.png';
        }
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return $this->path;
    }
}
