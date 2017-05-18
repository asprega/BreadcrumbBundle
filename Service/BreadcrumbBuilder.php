<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Service;

use AndreaSprega\Bundle\BreadcrumbBundle\Model\BreadcrumbItem;

/**
 * Provides a minimal interface to create a breadcrumb. This is used by the event listener if annotation are used, but
 * can also be used straight from controllers which want to customize their breadcrumb.
 */
class BreadcrumbBuilder
{
    /**
     * @var BreadcrumbItemFactory
     */
    private $itemFactory;

    /**
     * @var BreadcrumbItem[]
     */
    private $items = [];

    /**
     * @param BreadcrumbItemFactory $itemFactory
     */
    public function __construct(BreadcrumbItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    /**
     * Adds a new breadcrumb item.
     *
     * @param string $label
     * @param string|null $route
     * @param array|null $routeParams
     * @return BreadcrumbBuilder
     */
    public function addItem($label, $route = null, array $routeParams = null)
    {
        $this->items[] = $this->itemFactory->create($label, $route, $routeParams);
        return $this;
    }

    /**
     * Returns the current breadcrumb items.
     *
     * @return BreadcrumbItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
