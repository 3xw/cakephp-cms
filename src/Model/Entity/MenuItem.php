<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * MenuItem Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool|null $active
 * @property string $label
 * @property string|null $model
 * @property string|null $foreign_key
 * @property string|null $url
 * @property string|null $target
 * @property int|null $parent_id
 * @property int|null $left
 * @property int|null $rght
 * @property int $menu_id
 *
 * @property \App\Model\Entity\ParentMenuItem $parent_menu_item
 * @property \App\Model\Entity\Menu $menu
 * @property \App\Model\Entity\ChildMenuItem[] $child_menu_items
 */
class MenuItem extends Entity
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
