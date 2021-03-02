<?php
declare(strict_types=1);

namespace Trois\Cms\Test\TestCase\Model\Behavior;

use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use Trois\Cms\Model\Behavior\PageSlugBehavior;

/**
 * Trois\Cms\Model\Behavior\PageSlugBehavior Test Case
 */
class PageSlugBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Trois\Cms\Model\Behavior\PageSlugBehavior
     */
    protected $PageSlug;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $table = new Table();
        $this->PageSlug = new PageSlugBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PageSlug);

        parent::tearDown();
    }
}
