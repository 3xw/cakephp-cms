<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Page Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $lft
 * @property int $rght
 * @property string $title
 * @property string $slug
 * @property string|null $meta
 * @property string|null $header
 * @property string|null $body
 * @property string $page_template
 *
 * @property \Trois\Cms\Model\Entity\ParentPage $parent_page
 * @property \Trois\Cms\Model\Entity\ChildPage[] $child_pages
 * @property \Trois\Cms\Model\Entity\Section[] $sections
 * @property \Trois\Cms\Model\Entity\Attachment[] $attachments
 */
class Page extends Entity
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
