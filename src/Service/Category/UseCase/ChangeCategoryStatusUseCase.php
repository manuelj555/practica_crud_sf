<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace App\Service\Category\UseCase;

use App\Entity\Category;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;

/**
 * @author Manuel Aguirre
 */
class ChangeCategoryStatusUseCase
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function activate(Category $category): void
    {
        $category->setActive(true);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function inactivate(Category $category): void
    {
        $category->setActive(false);

        $errors = $this->validator->validate($category, groups: ["Inactivate"]);

        if (0 < count($errors)) {
            throw new ValidationException($errors);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
}