<?php
namespace Dokobit\Gateway\Result\Signing;

use Dokobit\Gateway\Result\ResultInterface;

/**
 * Result object for signing/{token}/seal response.
 */
class SealResult implements ResultInterface
{
    /** @var string response status */
    private $status;

    /** @var string token for mobile status query */
    private $token;

    /**
     * Fields expected in response
     * @return array
     */
    public function getFields()
    {
        return [
            'status',
            'token',
        ];
    }

    /**
     * Set status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Get status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Get token
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
