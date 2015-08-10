<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Tests\Model;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\ProcessedBreadcrumbItem;

/**
 * @coversDefaultClass \AndreaSprega\Bundle\BreadcrumbBundle\Model\ProcessedBreadcrumbItem
 */
class ProcessedBreadcrumbItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getTranslatedLabel
     * @covers ::getUrl
     */
    public function test_constructor()
    {
        $item = new ProcessedBreadcrumbItem('translated label', '/url');

        $this->assertEquals('translated label', $item->getTranslatedLabel());
        $this->assertEquals('/url', $item->getUrl());
    }
}
