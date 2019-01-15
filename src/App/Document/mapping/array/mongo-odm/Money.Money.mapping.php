<?php

use Doctrine\ODM\MongoDB\Types\Type;
use Money\Currency;
use Money\Money;

return [
    Money::class => [
        'type' => 'embeddedDocument',
        'fields' => [
            [
                'type' => Type::INTEGER,
                'fieldName' => 'amount',
            ],
        ],
        'embedOne' => [
            [
                'fieldName' => 'currency',
                'targetDocument' => Currency::class
            ],
        ],
    ]
];
