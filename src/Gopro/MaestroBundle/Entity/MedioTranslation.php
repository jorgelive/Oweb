<?php

namespace Gopro\MaestroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="mae_mediotranslation",
 *     uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 *
 */
class MedioTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="Medio", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}