<?php

namespace Gopro\SonataBundle\Exporter\Writer;

use Exporter\Writer\TypedWriterInterface;

class TxtWriter implements TypedWriterInterface
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var resource
     */
    protected $file;

    /**
     * @var int
     */
    protected $position;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->position = 0;

        if (is_file($filename)) {
            throw new \RuntimeException(sprintf('The file %s already exist', $filename));
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function getDefaultMimeType()
    {
        return 'application/txt';
    }

    /**
     * {@inheritdoc}
     */
    final public function getFormat()
    {
        return 'txt';
    }

    /**
     * {@inheritdoc}
     */
    public function open()
    {
        $this->file = fopen($this->filename, 'w', false);
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        fclose($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data)
    {
        //var_dump($data); die;

        fwrite($this->file, ($this->position > 0 ? chr(13) . chr(10). chr(13) . chr(10) : ''));
        $i = 0;
        foreach($data as $key => $value):
            fwrite($this->file, $key . ': ' . $value);
            fwrite($this->file, chr(13) . chr(10));
            $i++;
        endforeach;


        ++$this->position;
    }
}