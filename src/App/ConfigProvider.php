<?php

declare(strict_types=1);

namespace App;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'twig'         => $this->getTwig(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
                'form-components' => ['templates/form-components'],
            ]
        ];
    }
    
    public function getTwig()
    {
        return [
//            'autoescape' => 'html', // Auto-escaping strategy [html|js|css|url|false]
            'cache_dir' => 'data/cache/twig',
//            'assets_url' => 'base URL for assets',
//            'assets_version' => 'base version for assets',
            'extensions' => [
                new \App\TwigComponents\Filters\ForConcat()
            ],
            'helpers' => [
                \Twig_Extensions_Extension_Array::class,
            ],
            
            'globals' => [
                // Global variables passed to twig templates
                'ga_tracking' => 'UA-XXXXX-X'
            ],
            'optimizations' => -1, // -1: Enable all (default), 0: disable optimizations
//            'runtime_loaders' => [
//            ],
//            'timezone' => 'default timezone identifier, e.g. America/New_York',
        ];
    }
}
