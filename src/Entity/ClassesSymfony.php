<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * ClassesSymfony.
 *
 * @ORM\Entity
 */
class ClassesSymfony
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NamespaceSymfony", inversedBy="classesSymfony")
     */
    private $namespaceSymfony;

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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getNamespaceSymfony()
    {
        return $this->namespaceSymfony;
    }

    /**
     * @param mixed $namespaceSymfony
     */
    public function setNamespaceSymfony($namespaceSymfony): void
    {
        $this->namespaceSymfony = $namespaceSymfony;
    }

    /**
     * @return DateTime
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * @ORM Column(type="string", nullable=true).
     *
     * @param DateTime $created_at
     */
    public function setCreated_at(DateTime $created_at): self
    {
        return $this->created_at;
    }
}
