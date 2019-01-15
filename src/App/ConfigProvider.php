<?php

declare(strict_types=1);

namespace App;

use App\Handler\ExpensePageHandler;
use App\Handler\ExpensePageHandlerFactory;
use App\Handler\RevenuePageHandler;
use App\Handler\RevenuePageHandlerFactory;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\MongoDB\Configuration;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;
use Helderjs\Component\DoctrineMongoODM\AnnotationDriverFactory;
use Helderjs\Component\DoctrineMongoODM\ConfigurationFactory;
use Helderjs\Component\DoctrineMongoODM\ConnectionFactory;
use Helderjs\Component\DoctrineMongoODM\DocumentManagerFactory;
use Helderjs\Component\DoctrineMongoODM\EventManagerFactory;
use Helderjs\Component\DoctrineMongoODM\MappingDriverChainFactory;
use Helderjs\Component\DoctrineMongoODM\XmlDriverFactory;
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
        $this->registryAnnotations();
        
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
                \Doctrine\Common\Cache\ArrayCache::class => \Doctrine\Common\Cache\ArrayCache::class,
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Configuration::class   => ConfigurationFactory::class,
                Connection::class => ConnectionFactory::class,
                EventManager::class => EventManagerFactory::class,
                DocumentManager::class => DocumentManagerFactory::class,
                AnnotationDriver::class => AnnotationDriverFactory::class,
                XmlDriver::class => XmlDriverFactory::class,
                MappingDriverChain::class => MappingDriverChainFactory::class,
                
                
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                ExpensePageHandler::class => ExpensePageHandlerFactory::class,
                RevenuePageHandler::class => RevenuePageHandlerFactory::class
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
    
    private function registryAnnotations()
    {
        AnnotationDriver::registerAnnotationClasses();
    }
}
