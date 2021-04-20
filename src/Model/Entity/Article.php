<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Entity;

use Cake\ORM\Entity;

/**
* Article Entity
*
* @property int $id
* @property \Cake\I18n\FrozenTime $created
* @property \Cake\I18n\FrozenTime $modified
* @property string $status
* @property \Cake\I18n\FrozenTime $publish_date
* @property string $title
* @property string $slug
* @property string|null $meta
* @property string|null $header
* @property string|null $body
* @property string|null $user_id
*
* @property \Trois\Cms\Model\Entity\User $user
* @property \Trois\Cms\Model\Entity\Attachment[] $attachments
*/
class Article extends Entity
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
