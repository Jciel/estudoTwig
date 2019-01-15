<?php

declare(strict_types=1);

namespace App\Handler;

use App\Document\Expense;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
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

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        $collection = $this->documentManager->getDocumentCollection(Expense::class);
        $repository = $this->documentManager->getRepository(Expense::class);
        
        $result = $collection->aggregate([
            [
               '$addFields' => [
                    "expenses"=> []
               ]
            ],
            [
                '$group' => [
                    '_id' => '$month',
                    'totalValue' => [
                        '$sum' => '$value'
                    ],
                    'expenses'=> [
                        '$push' => [
                            'description' => '$description',
                            'value' =>'$value'
                        ]
                    ]
                ],
            ],
//                ['$sort' => [ '_id' => 1 ] ],
            [
                '$project' => [
                    '_id' => 1,
                    'totalValue' => '$totalValue',
                    'expenses' => '$expenses'
                ]
            ],
        ])->toArray();

        $expenses =[];
        array_walk($result, function ($expense) use (&$expenses) {
            $expenses[$expense['_id']] = $expense;
        });
        
       
        
//        echo '<pre>';
//        var_dump($expenses);
////        var_dump($repository->findAll());
//        echo '</pre>';
//        exit;
        

        return new HtmlResponse($this->template->render('app::home-page', ['expenses' => $expenses]));
    }
}
