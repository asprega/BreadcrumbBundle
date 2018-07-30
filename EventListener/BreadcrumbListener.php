<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\EventListener;

use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbBuilder;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class BreadcrumbListener
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var BreadcrumbBuilder
     */
    private $breadcrumbBuilder;

    /**
     * @param BreadcrumbBuilder $breadcrumbBuilder
     * @param Reader            $annotationReader
     */
    public function __construct(BreadcrumbBuilder $breadcrumbBuilder, Reader $annotationReader)
    {
        $this->breadcrumbBuilder = $breadcrumbBuilder;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        // Verification for non-array getController() such as ADR pattern: https://github.com/pmjones/adr
        if(!is_array($event->getController())) {
            return;
        }
        list($controller, $action) = $event->getController();

        $class = new \ReflectionClass($controller);
        $method = new \ReflectionMethod($controller, $action);

        $annotations = [];
        if (($classAnnotation = $this->annotationReader->getClassAnnotation($class, Breadcrumb::class))) {
            $annotations[] = $classAnnotation;
        }
        if ($methodAnnotation = $this->annotationReader->getMethodAnnotation($method, Breadcrumb::class)) {
            $annotations[] = $methodAnnotation;
        }

        foreach ($annotations as $annotation) {
            foreach ($annotation->items as $item) {
                $this->breadcrumbBuilder->addItem(
                    $item['label'],
                    isset($item['route']) ? $item['route'] : null,
                    isset($item['params']) ? $item['params'] : null
                );
            }
        }
    }
}
