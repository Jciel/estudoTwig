<?php

declare(strict_types=1);

namespace App\Handler;

use App\Document\Expense;
use Doctrine\ODM\MongoDB\DocumentManager;
use Money\Currency;
use Money\Money;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class ExpensePageHandler implements RequestHandlerInterface
{
    /** @var null|TemplateRendererInterface */
    private $template;

    /** @var DocumentManager */
    private $documentManager;

    public function __construct(DocumentManager $documentManager, ?TemplateRendererInterface $template = null)
    {
        $this->template      = $template;
        $this->documentManager = $documentManager;
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'GET') {
            return new HtmlResponse($this->template->render('app::expense', []));
        }
        
        $params = $request->getParsedBody();
        
        $value = new Money($params['value'], new Currency('BRL'));
        
        $expense = new Expense($params['description'], $value, $params['month']);
        
        $this->documentManager->persist($expense);
        $this->documentManager->flush();

        return new HtmlResponse($this->template->render('app::expense', []));

    }
}
