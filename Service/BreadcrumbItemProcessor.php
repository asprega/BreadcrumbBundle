<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;
use AndreaSprega\Bundle\BreadcrumbBundle\Model\ProcessedBreadcrumbItem;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Transforms BreadcrumbItems in ProcessedBreadcrumbItems by translating or gathering the value for the label and
 * turning the route + parameters into a URL.
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

    public function process(BreadcrumbItem $item, array $variables): ProcessedBreadcrumbItem
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

        if ($item->getRoute() !== null) {
            $processedUrl = $this->router->generate($item->getRoute(), $params);
        } else {
            $processedUrl = null;
        }

        return new ProcessedBreadcrumbItem($processedLabel, $processedUrl);
    }

    /**
     * Returns the value contained in the property path targeted by the given expression.
     */
    private function parseValue(string $expression, array $variables)
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
