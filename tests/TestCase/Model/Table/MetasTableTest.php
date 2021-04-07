<?php
declare(strict_types=1);

namespace Trois\Cms\Test\TestCase\Model\Table;

use Trois\Cms\Model\Table\MetasTable;
use Cake\TestSuite\TestCase;

/**
 * Trois\Cms\Model\Table\MetasTable Test Case
 */
class MetasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Trois\Cms\Model\Table\MetasTable
     */
    protected $Metas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Metas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Metas') ? [] : ['className' => MetasTable::class];
        $this->Metas = $this->getTableLocator()->get('Metas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Metas);

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
}
