<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $left
 * @property int $rght
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $name
 * @property string $slug
 * @property string $category_template
 * @property string|null $meta
 * @property string|null $header
 * @property string|null $body
 *
 * @property \Trois\Cms\Model\Entity\ParentCategory $parent_category
 * @property \Trois\Cms\Model\Entity\ChildCategory[] $child_categories
 * @property \Trois\Cms\Model\Entity\Faq[] $faqs
 */
class Category extends Entity
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
