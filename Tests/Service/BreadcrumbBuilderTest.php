<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Tests\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;
use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbBuilder;
use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbItemFactory;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbBuilder
 */
class BreadcrumbBuilderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var BreadcrumbBuilder
     */
    private $builder;

    /**
     * @var BreadcrumbItemFactory|\Mockery\MockInterface
     */
    private $itemFactory;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->itemFactory = \Mockery::mock(BreadcrumbItemFactory::class);
        $this->builder = new BreadcrumbBuilder($this->itemFactory);
    }

    /**
     * @covers ::__construct
     * @covers ::getItems
     */
    public function test_getItems_emptyBreadcrumb()
    {
        $this->assertEmpty($this->builder->getItems());
    }

    /**
     * @covers ::__construct
     * @covers ::addItem
     * @covers ::getItems
     */
    public function test_getItems_nonEmptyBreadcrumb()
    {
        $item1 = \Mockery::mock(BreadcrumbItem::class);
        $this->itemFactory->shouldReceive('create')->with('aLabel', 'aRoute', null, null)->andReturn($item1);
        $item2 = \Mockery::mock(BreadcrumbItem::class);
        $this->itemFactory->shouldReceive('create')->with('anotherLabel', 'anotherRoute', [ 'a' => 'b' ], null)
            ->andReturn($item2);

        $this->builder->addItem('aLabel', 'aRoute');
        $this->builder->addItem('anotherLabel', 'anotherRoute', [ 'a' => 'b' ]);

        $this->assertEquals([ $item1, $item2 ], $this->builder->getItems());
    }
}
