<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Tests\Model;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem
 */
class BreadcrumbItemTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @covers ::__construct
     * @covers ::getLabel
     * @covers ::getRoute
     * @covers ::getRouteParams
     * @covers ::getTranslationDomain
     */
    public function test_constructor()
    {
        $item = new BreadcrumbItem('label', 'route', ['param' => 'value'], 'domain');

        $this->assertEquals('label', $item->getLabel());
        $this->assertEquals('route', $item->getRoute());
        $this->assertEquals(['param' => 'value'], $item->getRouteParams());
        $this->assertEquals('domain', $item->getTranslationDomain());
    }
}
