<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Money\Currency;
use Money\Money;

/**
 * @ODM\Document(collection="Revenue")
 */
class Revenue
{
    /**
     * @var int
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $description;

    /**
     * @var int
     *
     * @ODM\Field(type="int")
     */
    private $value;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $month;

    public function __construct(string $description, Money $value, string $month)
    {
        $this->description = $description;
        $this->value = (int)$value->getAmount();
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Money
     */
    public function getValue(): Money
    {
        return new Money($this->value, new Currency("BRL"));
    }

    /**
     * @param Money $value
     */
    public function setValue(Money $value): void
    {
        $this->value = (int)$value->getAmount();
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @param string $month
     */
    public function setMonth(string $month): void
    {
        $this->month = $month;
    }
}
