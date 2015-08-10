<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;
use AndreaSprega\Bundle\BreadcrumbBundle\Model\ProcessedBreadcrumbItem;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * TODO class description
 */
class BreadcrumbItemProcessor
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     * @param TranslatorInterface       $translator
     * @param RouterInterface           $router
     * @param RequestStack              $requestStack
     */
    public function __construct(
        PropertyAccessorInterface $propertyAccessor,
        TranslatorInterface $translator,
        RouterInterface $router,
        RequestStack $requestStack
    ) {
        $this->propertyAccessor = $propertyAccessor;
        $this->translator = $translator;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    /**
     * @param BreadcrumbItem $item
     * @param array          $variables
     * @return ProcessedBreadcrumbItem
     */
    public function process(BreadcrumbItem $item, $variables)
    {
        // Process the label
        if ($item->getLabel()[0] === '$') {
            $processedLabel = $this->parseValue($item->getLabel(), $variables);
        } else {
            $processedLabel = $this->translator->trans($item->getLabel());
        }

        // Process the route
        // TODO: cache parameters extracted from current request
        $params = [];
        foreach ($this->requestStack->getCurrentRequest()->attributes as $key => $value) {
            if ($key[0] !== '_') {
                $params[$key] = $value;
            }
        }
        foreach ($item->getRouteParams() ?: [] as $key => $value) {
            if ($value[0] === '$') {
                $params[$key] = $this->parseValue($value, $variables);
            } else {
                $params[$key] = $value;
            }
        }

        if ($item->getRoute()) {
            $processedUrl = $this->router->generate($item->getRoute(), $params);
        } else {
            $processedUrl = null;
        }

        return new ProcessedBreadcrumbItem($processedLabel, $processedUrl);
    }

    /**
     * Returns the value contained in the property path targeted by the given expression.
     *
     * @param string $expression
     * @param array $variables
     * @return mixed
     */
    private function parseValue($expression, $variables)
    {
        list($variable, $propertyPath) = explode('.', $expression, 2);
        $variable = substr($variable, 1); // Remove the $ prefix
        if (!array_key_exists($variable, $variables)) {
            throw new \RuntimeException('The variables array passed to process the breadcrumb item does not have'
                . ' variable "' . $variable . '". Make sure you are passing that variable to the template where this'
                . ' breadcrumb is rendered.');
        }

        return $this->propertyAccessor->getValue($variables[$variable], $propertyPath);
    }
}
