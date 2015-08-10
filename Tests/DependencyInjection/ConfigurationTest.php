<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Tests\DependencyInjection;

use AndreaSprega\Bundle\BreadcrumbBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

/**
 * @coversDefaultClass \AndreaSprega\Bundle\BreadcrumbBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the configuration when overriding the template.
     *
     * @covers ::getConfigTreeBuilder
     */
    public function test_load_overrideTemplate()
    {
        $config = [
            'asprega_breadcrumb' => [
                'template' => 'aTemplate.html.twig'
            ]
        ];

        $processor = new Processor();
        $processedConfig = $processor->processConfiguration(new Configuration(true), $config);

        $this->assertEquals([ 'template' => 'aTemplate.html.twig' ], $processedConfig);
    }
}
