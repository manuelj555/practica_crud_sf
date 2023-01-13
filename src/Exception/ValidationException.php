<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Manuel Aguirre
 */
class ValidationException extends Exception
{
    public function __construct(ConstraintViolationListInterface $errors)
    {
        parent::__construct($errors->get(0)->getMessage());
    }
}