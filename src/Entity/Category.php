<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use App\Service\Category\Constraints\EmptyProductsOnInactive;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity("code", message: "Este codigo ya esta en uso")]
#[UniqueEntity("name", message: "Este nombre de categoria ya está en uso")]
#[EmptyProductsOnInactive(groups: ["Inactivate"])]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[NotBlank]
    private ?string $code = null;

    #[ORM\Column(length: 100)]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    private bool $active = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
