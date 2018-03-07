<?php
namespace Isign\Gateway\Result;

/**
 * Result object for signing/create response.
 */
class SigningCreateResult implements ResultInterface
{
    /** @var string response status */
    private $status;

    /** @var string token for mobile status query */
    private $token;

    /** @var array document signers */
    private $signers;

    /**
     * Fields expected in response
     * @return array
     */
    public function getFields()
    {
        return [
            'status',
            'token',
            'signers',
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

    /**
     * Set signers
     */
    public function setSigners(?array $signers): void
    {
        $this->signers = $signers;
    }

    /**
     * Get signers
     */
    public function getSigners(): ?array
    {
        return $this->signers;
    }
}
