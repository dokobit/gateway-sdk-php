<?php
namespace Dokobit\Gateway;

use Dokobit\Gateway\Result\ResultInterface;

/**
 * Response mapper interface for building response mappers.
 */
interface ResponseMapperInterface
{
    /**
     * Map response to result objects
     * @param array $response
     * @param ResultInterface $result
     * @return ResultInterface
     */
    public function map(array $response, ResultInterface $result): ResultInterface;
}
