<?php
namespace Dokobit\Gateway\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Validator found violations while validating query field values
 */
class QueryValidator extends \InvalidArgumentException
{
    /** @var ConstraintViolationList */
    private $violations;

    /**
     * @param string $message
     * @param ConstraintViolationList $violations
     * @return self
     */
    public function __construct($message, ConstraintViolationList $violations)
    {
        parent::__construct($message . ': ' . (string)$violations);

        $this->violations = $violations;
    }

    /**
     * Get validation violations
     * @return ConstraintViolationList
     */
    public function getViolations(): ConstraintViolationList
    {
        return $this->violations;
    }
}
