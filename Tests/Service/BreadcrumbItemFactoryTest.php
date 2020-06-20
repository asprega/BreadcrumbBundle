<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Tests\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;
use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbItemFactory;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbItemFactory
 */
class BreadcrumbItemFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @covers ::create
     */
    public function test_create()
    {
        $factory = new BreadcrumbItemFactory();

        $item = $factory->create('aLabel', 'aRoute');

        $this->assertTrue($item instanceof BreadcrumbItem);
    }
}
