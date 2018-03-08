<?php
namespace Isign\Gateway\Result\Signing;

use Isign\Gateway\Result\ResultInterface;

/**
 * Result object for signing/{token}/addsigner response.
 */
class AddSignerResult implements ResultInterface
{
    /** @var string response status */
    private $status;

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
