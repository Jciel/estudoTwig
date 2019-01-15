<?php

use Doctrine\ODM\MongoDB\Types\Type;
use Money\Currency;

return [
    Currency::class => [
        'type' => 'embeddedDocument',
        'fields' => [
            [
                'type' => Type::STRING,
                'fieldName' => 'name',
            ],
        ],
    ]
];
