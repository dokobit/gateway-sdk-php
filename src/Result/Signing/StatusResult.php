<?php
namespace Isign\Gateway\Result\Signing;

use Isign\Gateway\Result\ResultInterface;

/**
 * Result object for signing/{token}/status response.
 */
class StatusResult implements ResultInterface
{

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_ARCHIVED = 'archived';
    const STATUS_FAILED = 'failed';

    const SIGNER_STATUS_PENDING = 'pending';
    const SIGNER_STATUS_SIGNED = 'signed';
    const SIGNER_STATUS_FAILED = 'failed';

    /** @var string signing status */
    private $status;

    /** @var array signer information */
    private $signers;

    /** @var string file URL */
    private $file;

    /** @var string signing validity date */
    private $validTo;

    /** @var array */
    private $structure;

    /**
     * Fields expected in response
     */
    public function getFields(): array
    {
        return [
            'status',
            'signers',
            'file',
            'validTo',
            'structure',
        ];
    }

    /**
     * Set signing status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Get signing status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set signers
     */
    public function setSigners(array $signers): void
    {
        $this->signers = $signers;
    }

    /**
     * Get signers
     */
    public function getSigners(): array
    {
        return $this->signers;
    }

    /**
     * Set file URL
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * Get file URL
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Set signing validity date
     */
    public function setValidTo(string $validTo): void
    {
        $this->validTo = $validTo;
    }

    /**
     * Get signing validity date
     */
    public function getValidTo(): string
    {
        return $this->validTo;
    }

    /**
     * Set structure
     */
    public function setStructure(array $stucture): void
    {
        $this->structure = $structure;
    }

    /**
     * Get structure
     */
    public function getStructure(): array
    {
        return $this->structure;
    }
}
