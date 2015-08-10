<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;

/**
 * Creates breadcrumb items with label an related route + parameters.
 */
class BreadcrumbItemFactory
{
    /**
     * @param string      $label
     * @param string|null $route
     * @param array|null  $routeParams
     * @return BreadcrumbItem
     */
    public function create($label, $route = null, array $routeParams = null)
    {
        return new BreadcrumbItem($label, $route, $routeParams);
    }
}
