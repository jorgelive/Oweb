<?php

namespace Gopro\CotizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="cot_cotpoliticatranslation",
 *     uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 *
 */
class CotpoliticaTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="Cotpolitica", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}