<?php
namespace Dokobit\Gateway\Exception;

/**
 * Base exception for request errors
 */
class Request extends \RuntimeException
{
    /** @var mixed response data */
    private $responseData;

    /**
     * @param string $message
     * @param integer $code
     * @param \Exception $previousException
     * @param mixed $responseData
     * @return self
     */
    public function __construct(
        $message,
        $code,
        \Exception $previousException = null,
        $responseData = null
    ) {
        $message .= ' Response: ' . var_export($responseData, true);
        parent::__construct($message, $code, $previousException);
        $this->responseData = $responseData;
    }

    /**
     * Response data
     * @return mixed
     */
    public function getResponseData()
    {
        return $this->responseData;
    }
}
