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


    private $temp;

    private $tempThumb;

    /**
     * @Assert\File(maxSize = "2M")
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

        if (is_file($this->getInternalFullPath())) {
            $this->temp = $this->getInternalFullPath();
        }

        if (is_file($this->getInternalFullThumbPath())) {
            $this->tempThumb = $this->getInternalFullThumbPath();
        }

        $this->extension = 'initial';

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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getArchivo() || $this->archivo ) {
            //$this->extension = $this->getArchivo()->guessExtension();
            $this->extension = $this->getArchivo()->getClientOriginalExtension();
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
        if ($this->getArchivo() === null) {
            return;
        }
        if (!empty($this->temp)){
            unlink($this->temp);
            $this->temp = null;
        }
        if (!empty($this->tempThumb)){
            unlink($this->tempThumb);
            $this->tempThumb = null;
        }

        $imageTypes = ['image/jpeg'];

        if(in_array($this->getArchivo()->getMimeType(), $imageTypes )){

        }
        //debe ir antes ta que la imagen sera movida
        $this->generarThumb($this->getArchivo()->getPathname());
        $this->getArchivo()->move($this->getInternalFullDir(), $this->id . '.' . $this->extension);
        $this->setArchivo(null);
    }


    public function generarThumb($image){
        // Create Imagick object
        $im = new \Imagick();
        $im->readImage($image); //Read the file

        $im->resizeImage( 200 , 200 , \Imagick::FILTER_LANCZOS, 1, TRUE);

        if(!is_dir($this->getInternalFullThumbDir())){
            mkdir($this->getInternalFullThumbDir(), 0755, true);
        }
        //return $im->writeImages('C:\wamp\temp', true);
        return $im->writeImages($this->getInternalFullThumbPath(), true);

    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getInternalFullPath();
        if(!empty($this->getInternalFullThumbPath())){
            $this->tempThumb = $this->getInternalFullThumbPath();
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (!empty($this->temp)) {
            unlink($this->temp);
        }
        if (!empty($this->tempThumb)) {
            unlink($this->tempThumb);
        }
    }

    protected function getInternalFullDir()
    {
        return __DIR__ . '/../../../../web' . $this->getWebDir();
    }

    public function getInternalFullPath()
    {
        if($this->extension === null){
            return null;
        }

        return $this->getInternalFullDir() . '/' . $this->id . '.' . $this->extension;
    }

    public function getWebPath()
    {
        if($this->extension === null){
            return null;
        }
        return $this->getWebDir() . '/' . $this->id . '.' . $this->extension;
    }

    public function getInternalFullThumbPath()
    {
        if($this->extension === null || empty($this->getInternalFullThumbDir())){
            return null;
        }
        return $this->getInternalFullThumbDir() . '/' . $this->id . '.' . $this->extension;
    }

    protected function getInternalFullThumbDir()
    {
        if(in_array($this->extension, ['jpg', 'jpeg', 'png', ''])){

            return __DIR__ . '/../../../../web' . $this->getWebThumbDir();
        }
        return null;
    }

    public function getWebThumbPath()
    {
        if($this->extension === null){
            return null;
        }
        if(in_array($this->extension, ['jpg', 'jpeg', 'png'])){
            return $this->getWebThumbDir() . '/' . $this->id . '.' . $this->extension;
        }else{
            return $this->getWebThumbDir() . '/' . $this->getIcon($this->extension) . '.png';
        }
    }

    public function getIcon($extension){
        $tipos['image'] = ['tiff', 'tif', 'gif'];
        $tipos['word'] = ['doc', 'docx', 'rtf'];
        $tipos['text'] = ['txt'];
        $tipos['pdf'] = ['pdf'];
        $tipos['excel'] = ['xls', 'xlsx'];
        $tipos['powerpoint'] = ['ppt', 'pptx', 'ppsx', 'pps'];

        foreach($tipos as $key => $tipo):
            if(in_array($extension, $tipo)){
                return $key;
            }
        endforeach;

        return 'developer';
    }

    public function getWebThumbDir()
    {
        if(in_array($this->extension, ['jpg', 'jpeg', 'png'])){
            return $this->getWebDir() . '/thumb';
        }else{
            return '/bundles/gopromain/images/icons';
        }

    }


    protected function getWebDir()
    {
        return $this->path;
    }
}
