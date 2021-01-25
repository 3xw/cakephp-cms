<?php
declare(strict_types=1);

namespace Trois\Cms\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Trois\Cms\Model\Table\SectionItemsTable;

/**
 * Trois\Cms\Model\Table\SectionItemsTable Test Case
 */
class SectionItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Trois\Cms\Model\Table\SectionItemsTable
     */
    protected $SectionItems;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Trois/Cms.SectionItems',
        'plugin.Trois/Cms.Sections',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SectionItems') ? [] : ['className' => SectionItemsTable::class];
        $this->SectionItems = $this->getTableLocator()->get('SectionItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SectionItems);

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
