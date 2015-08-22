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

    /**
     * @param string      $translatedLabel
     * @param string|null $url
     */
    public function __construct($translatedLabel, $url = null)
    {
        $this->translatedLabel = $translatedLabel;
        $this->url = $url;
    }

    /**
     * Returns the translated label for this processed breadcrumb item.
     *
     * @return string
     */
    public function getTranslatedLabel()
    {
        return $this->translatedLabel;
    }

    /**
     * Returns the URL (if present) for this processed breadcrumb item.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }
}
