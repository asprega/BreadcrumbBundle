<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Twig;

use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbBuilder;
use AndreaSprega\Bundle\BreadcrumbBundle\Service\BreadcrumbItemProcessor;

class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var BreadcrumbBuilder
     */
    private $builder;

    /**
     * @var BreadcrumbItemProcessor
     */
    private $itemProcessor;

    /**
     * @var string
     */
    private $template;

    /**
     * @param BreadcrumbBuilder       $builder
     * @param BreadcrumbItemProcessor $itemProcessor
     * @param string                  $template
     */
    public function __construct(BreadcrumbBuilder $builder, BreadcrumbItemProcessor $itemProcessor, $template)
    {
        $this->builder = $builder;
        $this->itemProcessor = $itemProcessor;
        $this->template = $template;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'asprega_breadcrumb',
                [ $this, 'renderBreadcrumb' ],
                [
                    'is_safe' => [ 'html' ],
                    'needs_environment' => true,
                    'needs_context' => true
                ]
            )
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asprega_breadcrumb';
    }

    /**
     * Returns the rendered breadcrumb.
     *
     * @param \Twig_Environment $twig
     * @param array             $context Twig context containing all the view variables.
     * @return string
     */
    public function renderBreadcrumb(\Twig_Environment $twig, array $context)
    {
        $breadcrumb = [];
        foreach ($this->builder->getItems() as $item) {
            $breadcrumb[] = $this->itemProcessor->process($item, $context);
        }

        return $twig->render($this->template, [ 'items' => $breadcrumb ]);
    }
}
