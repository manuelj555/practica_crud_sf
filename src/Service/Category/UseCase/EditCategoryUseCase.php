<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace App\Service\Category\UseCase;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Manuel Aguirre
 */
class EditCategoryUseCase
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
}