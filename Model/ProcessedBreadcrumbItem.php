<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\Model;

/**
 * The final model containing the translated label and the URL (optional) related to a breadcrumb item.
 */
class ProcessedBreadcrumbItem
{
    /**
     * @var string
     */
    private $translatedLabel;

    /**
     * @var string|null
     */
    private $url;

    public function __construct(string $translatedLabel, ?string $url = null)
    {
        $this->translatedLabel = $translatedLabel;
        $this->url = $url;
    }

    public function getTranslatedLabel(): string
    {
        return $this->translatedLabel;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
