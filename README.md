# AndreaSpregaBreadcrumbBundle

[![Latest Stable Version](https://poser.pugx.org/asprega/breadcrumb-bundle/v/stable)](https://packagist.org/packages/asprega/breadcrumb-bundle)
[![Build Status](https://travis-ci.org/asprega/BreadcrumbBundle.svg)](https://travis-ci.org/asprega/BreadcrumbBundle)
[![Total Downloads](https://poser.pugx.org/asprega/breadcrumb-bundle/downloads)](https://packagist.org/packages/asprega/breadcrumb-bundle)
[![License](https://poser.pugx.org/asprega/breadcrumb-bundle/license)](https://packagist.org/packages/asprega/breadcrumb-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7f13817a-3765-42f5-becb-0990a1219e39/mini.png)](https://insight.sensiolabs.com/projects/7f13817a-3765-42f5-becb-0990a1219e39)

This bundle provides a way to create "dynamic" breadcrumbs in your Symfony2 applications.

## Installation

Composer is the only supported installation method. Run the following to install the latest version from Packagist:

``` bash
composer require asprega/breadcrumb-bundle
```

Or, if you prefer, you can require any version in your `composer.json`:

``` json
{
    "require": {
        "asprega/breadcrumb-bundle": "*"
    }
}
```

*NOTE:* Until the bundle reaches version 1.0.0 I can't guarantee to follow [semantic versioning](http://semver.org) strictly.

## Usage

### 1. Load bundle

Once installed, load the bundle in your Kernel class:

``` php
// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new AndreaSprega\Bundle\BreadcrumbBundle\AndreaSpregaBreadcrumbBundle(),
        );
        // ...
    }
    // ...
}
```

### 2. Define breadcrumbs

There are two ways to create a breadcrumb: via code (1) or via annotations (2).

*Via code*: you can retrieve the breadcrumb builder in your controller and add breadcrumb items:

``` php
public function coolStuffAction()
{
    // ...

    $builder = $this->get('asprega.breadcrumb.builder');
    $builder->addItem('home', 'home_route');
    $builder->addItem('$entity.property', 'entity_route');
    $builder->addItem('cool_stuff');

    // ...
}
```

*Via annotations*: just use the `@Breadcrumb` annotation at the class and/or method level. They will be merged (class comes first).

*NOTE:* The annotation can take either a single item (in the above example it's done at the class level) or multiple items (at the method level).

``` php
<?php

use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;

/**
 * @Breadcrumb({"label" = "home", "route" = "home_route", "params" = { "p" = "val" } })
 */
class CoolController extends Controller
{
    /**
     * @Breadcrumb({
     *   { "label" = "$entity.property", "route" = "entity_route" },
     *   { "label" = "cool_stuff" }
     * })
     */
    public function coolStuffAction()
    {
        // ...
    }
```

### 3. Render breadcrumb

The last step is to use the following Twig function wherever you want the breadcrumb printed in your template:

``` php
asprega_breadcrumb()
```

Regardless of the way you used to create the breadcrumb, the result will be something like:

```
Home > Value of entity property > Cool stuff
```

In which the first two items are anchors and the last one is text only.

### How the breadcrumb is generated

Under the hood, this is the business logic involved, for each item, in the breadcrumb generation:
* `label` will be the printed text. It can be either:
  * A "static" string (the translator will attempt to translate it by using it as a translation key)
  * A special string using the format `$name.property.path`. In this case, the `name` variable passed to the view will be used to extract the value at `property.path`. That value will be the breadcrumb text. This is useful when the item title should depend on an attribute (e.g. name) of a "parent" entity.
* `route` will be used to generate the url for the item anchor (if provided). If not provided, the item will not be clickable.
* `params` will be used to generate the url related to the provided route. It's an associative array where each value can be either:
  * A "static" string
  * A "special" string using the format `$name.property.path`. The treatment is exactly the same as in "label". This is useful to dynamically retrieve url params (e.g. entity ID) starting from view variables.

*NOTE:* one of the coolest feature of this bundle is that **you don't need to pass all the route parameters that are needed by route, as long as these route parameters are already present in the URL for the current request**. In other words, if your breadcrumb hierarchical structure somehow "matches" your URL structure.

Example: suppose you have the following routes, with parameters and resulting URLs:

```
parent_list   |                                       | /parents
parent_view   | { parent_id: 12345 }                  | /parents/12345
children_list | { parent_id: 12345 }                  | /parents/12345/children
child_view    | { parent_id: 12345, child_id: 67890 } | /parents/12345/children/67890
child_edit    | { parent_id: 12345, child_id: 67890 } | /parents/12345/children/67890/edit
```

If you are in the action for route `children_edit` and you want to generate a breadcrumb including all the above steps, you will be able to use the following annotation:

``` php
/**
 * @Breadcrumb({
 *   { "label" = "parents", "route" = "parent_list" },
 *   { "label" = "$parent.name", "route" = "parent_view" },
 *   { "label" = "children", "route" = "children_list" },
 *   { "label" = "$child.name", "route" = "child_view" },
 *   { "label" = "edit" }
 * })
 */
public function childrenEditAction($parentID, $childrenID)
{
    // ...
}
```

Note how you don't have to provide the route parameters (since the current request already has them all). It would work the same if you build it via code instead.

## Override breadcrumb template

The bundle default template for rendering breadcrumb can be overridden by adding the following lines to the `config.yml` of your application:

``` yml
asprega_breadcrumb:
    template: YourBundle::breadcrumb.html.twig
```

If you intend to do this, it's recommended to copy `Resources/views/breadcrumb.html.twig` to your bundle and customize it.
However, in your template you'll just have to iterate over the `items` variable to render your custom breadcrumb.

## How to contribute

* Did you find and fix any bugs in the existing code?
* Do you want to contribute a new cool feature?
* Do you think documentation isn't good enough and you think you can improve it?

Under any of these circumstances, please fork this repo and create a pull request. I am more than happy to accept contributions!

## Maintainer

[@andreasprega](https://twitter.com/andreasprega)
