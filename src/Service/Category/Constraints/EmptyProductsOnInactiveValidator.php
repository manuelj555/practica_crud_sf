<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace App\Service\Category\Constraints;

use App\Entity\Category;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use function dump;

/**
 * @author Manuel Aguirre
 */
class EmptyProductsOnInactiveValidator extends ConstraintValidator
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        /** @var Category $value */
        if ($value->isActive() or !$value->getId()) {
            return;
        }

        if (0 === $this->productRepository->count(['category' => $value])) {
            return;
        }

        $this->context->buildViolation($constraint->message)->addViolation();
    }
}