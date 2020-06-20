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

    public function __construct(BreadcrumbItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    /**
     * Adds a new breadcrumb item.
     */
    public function addItem(string $label, ?string $route = null, ?array $routeParams = null): BreadcrumbBuilder
    {
        $this->items[] = $this->itemFactory->create($label, $route, $routeParams);
        return $this;
    }

    /**
     * Returns the current breadcrumb items.
     *
     * @return BreadcrumbItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
