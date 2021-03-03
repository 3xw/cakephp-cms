<?php
declare(strict_types=1);

namespace Trois\Cms\Test\TestCase\Model\Table;

use Trois\Cms\Model\Table\MenuItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MenuItemsTable Test Case
 */
class MenuItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MenuItemsTable
     */
    protected $MenuItems;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MenuItems',
        'app.Menus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MenuItems') ? [] : ['className' => MenuItemsTable::class];
        $this->MenuItems = $this->getTableLocator()->get('MenuItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MenuItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
