<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Model;

/**
 * Acts as a "temporary" model which keeps information for the processor to manipulate. Will ultimately be turned into
 * a ProcessedBreadcrumbItem.
 */
class BreadcrumbItem
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string|null
     */
    private $route;

    /**
     * @var array|null
     */
    private $routeParams;

    public function __construct(string $label, ?string $route = null, ?array $routeParams = null)
    {
        $this->label = $label;
        $this->route = $route;
        $this->routeParams = $routeParams;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function getRouteParams(): ?array
    {
        return $this->routeParams;
    }
}
