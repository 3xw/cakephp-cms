<?php
declare(strict_types=1);

namespace Trois\Cms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Trois\Cms\Model\Table\ModuleItemsTable;

/**
 * Trois\Cms\Model\Table\ModuleItemsTable Test Case
 */
class ModuleItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Trois\Cms\Model\Table\ModuleItemsTable
     */
    protected $ModuleItems;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Trois/Cms.ModuleItems',
        'plugin.Trois/Cms.Modules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ModuleItems') ? [] : ['className' => ModuleItemsTable::class];
        $this->ModuleItems = $this->getTableLocator()->get('ModuleItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ModuleItems);

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
