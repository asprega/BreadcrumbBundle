<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle;

use AndreaSprega\Bundle\BreadcrumbBundle\DependencyInjection\AndreaSpregaBreadcrumbExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AndreaSpregaBreadcrumbBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new AndreaSpregaBreadcrumbExtension();
    }
}
