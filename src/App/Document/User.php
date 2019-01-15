<?php

namespace App\Document;

//use Doctrine\Common\Annotations\Annotation as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * @ODM\Document(collection="User")
 */
class User
{
    /**
     * @var int
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field
     */
    private $name;

    /**
     * @var string
     * @ODM\Field
     */
    private $email;
    
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
