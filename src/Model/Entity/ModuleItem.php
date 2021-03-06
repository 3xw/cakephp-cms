<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModuleItem Entity
 *
 * @property int $id
 * @property int $module_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $order
 * @property string $model
 * @property string $foreign_key
 * @property string|null $meta
 *
 * @property \Trois\Cms\Model\Entity\Module $module
 */
class ModuleItem extends Entity
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
