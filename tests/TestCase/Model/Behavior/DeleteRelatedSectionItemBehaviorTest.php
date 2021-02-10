<?php
declare(strict_types=1);

namespace Trois\Cms\Test\TestCase\Model\Behavior;

use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use Trois\Cms\Model\Behavior\DeleteRelatedSectionItemBehaviorBehavior;

/**
 * Trois\Cms\Model\Behavior\DeleteRelatedBehavior Test Case
 */
class DeleteRelatedSectionItemBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Trois\Cms\Model\Behavior\DeleteRelatedSectionItemBehaviorBehavior
     */
    protected $DeleteRelated;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $table = new Table();
        $this->DeleteRelatedSectionItemBehaviorBehavior = new DeleteRelatedSectionItemBehaviorBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DeleteRelatedSectionItemBehaviorBehavior);

        parent::tearDown();
    }
}
