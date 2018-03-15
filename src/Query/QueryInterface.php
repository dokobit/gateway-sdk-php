<?php
namespace Isign\Gateway\Query;

use Isign\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints\Collection as AssertCollection;

/**
 * Query interface for building queries for API.
 */
interface QueryInterface
{
    /**
     * HTTP method POST
     */
    const POST = 'POST';

    /**
     * HTTP method GET
     */
    const GET = 'GET';

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string;

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array;

    /**
     * Result object for this query result
     * @return ResultInterface
     */
    public function createResult(): ?ResultInterface;

    /**
     * Validation constraints for fields
     * @return AssertCollection
     */
    public function getValidationConstraints(): AssertCollection;

    /**
     * HTTP method to use
     * @return string
     */
    public function getMethod(): string;
}
