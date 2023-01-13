<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace App\Service\Category\UseCase;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @author Manuel Aguirre
 */
class CreateCategoryUseCase
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(FormInterface $form): Category
    {
        $category = $form->getData();

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}