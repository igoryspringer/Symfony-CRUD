<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * NamespaceSymfony.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class NamespaceSymfony
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="childrens")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="NamespaceSymfony", mappedBy="parent")
     */
    private $childrens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClassesSymfony", mappedBy="namespaceSymfony")
     */
    private $classesSymfony;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InterfaceSymfony", mappedBy="namespaceSymfony")
     */
    protected $interfaceSymfony;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /*
     * @param int $id
     *
    public function setId(int $id): void
    {
        $this->id = $id;
    }*/

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
     * @return DateTimeInterface
     */
    public function getCreated_at(): DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @ORM Column(type="string", nullable=true).
     *
     * @param DateTimeInterface $created_at
     */
    public function setCreated_at(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }
}
