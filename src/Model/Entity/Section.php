<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Section Entity
 *
 * @property int $id
 * @property int $page_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $section_template
 * @property int $order
 *
 * @property \Trois\Cms\Model\Entity\Page $page
 * @property \Trois\Cms\Model\Entity\SectionItem[] $section_items
 */
class Section extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     protected $_accessible = [
       '*' => true,         
      'id' => false,
            ];
}
