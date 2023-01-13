<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace App\Service\Category\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @author Manuel Aguirre
 */
#[Attribute(Attribute::TARGET_CLASS)]
class EmptyProductsOnInactive extends Constraint
{
    public string $message = 'No puede inactivar una categoria con productos relacionados';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}