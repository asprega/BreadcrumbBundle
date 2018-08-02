<?php

use AndreaSprega\Bundle\BreadcrumbBundle\EventListener\BreadcrumbListener;
use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbBuilder;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @coversDefaultClass \AndreaSprega\Bundle\BreadcrumbBundle\EventListener\BreadcrumbListener
 */
class BreadcrumbListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_does_not_try_to_parse_annotations_when_controller_is_not_an_array()
    {
        $breadcrumbBuilder = \Mockery::mock(BreadcrumbBuilder::class);
        $annotationReader = \Mockery::mock(Reader::class);

        $SUT = new BreadcrumbListener($breadcrumbBuilder, $annotationReader);

        $event = \Mockery::mock(FilterControllerEvent::class, ['getController' => function () {}]);
        $annotationReader->shouldReceive('getClassAnnotation')->never();
        $annotationReader->shouldReceive('getMethodAnnotation')->never();
        $breadcrumbBuilder->shouldReceive('addItem')->never();

        $SUT->onKernelController($event);
    }
}
