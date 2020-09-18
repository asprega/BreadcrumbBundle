<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;

/**
 * Creates breadcrumb items with label an related route + parameters.
 */
class BreadcrumbItemFactory
{
    public function create(
        ?string $label = null,
        ?string $route = null,
        ?array $routeParams = null,
        $translationDomain = null
    ): BreadcrumbItem {
        return new BreadcrumbItem($label, $route, $routeParams, $translationDomain);
    }
}
