<?php

declare(strict_types=1);

namespace App\Handler;

use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ExpensePageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        /** @var DocumentManager $documentManager */
        $documentManager = $container->get(DocumentManager::class);

        return new ExpensePageHandler($documentManager, $template);
    }
}
