<?php
namespace Isign\Gateway\Result;

/**
 * Result interface for building result objects.
 */
interface ResultInterface
{
    /**
     * Identifies successful API response
     */
    const STATUS_OK = 'ok';

    /**
     * API's error response
     */
    const STATUS_ERROR = 'error';

    /**
     * Transaction in progress. Repeat request in few seconds.
     */
    const STATUS_WAITING = 'waiting';

    /**
     * Unexpected error occurred
     */
    const STATUS_UNKNOWN = 'unknown';

    /**
     * Fields expected in response
     * @return array
     */
    public function getFields();
}
