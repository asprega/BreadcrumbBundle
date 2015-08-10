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

    /**
     * @param string $label
     * @param string $route
     * @param array  $routeParams
     */
    public function __construct($label, $route = null, $routeParams = null)
    {
        $this->label = $label;
        $this->route = $route;
        $this->routeParams = $routeParams;
    }

    /**
     * Returns the label for this breadcrumb item.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the route name for this breadcrumb item.
     *
     * @return string|null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Returns the route parameters for this breadcrumb item.
     *
     * @return array|null
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }
}
