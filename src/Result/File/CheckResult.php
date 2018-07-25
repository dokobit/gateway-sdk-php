<?php
namespace Dokobit\Gateway\Result\File;

use Dokobit\Gateway\Result\ResultInterface;

/**
 * Result object for file/check response.
 */
class CheckResult implements ResultInterface
{
    /** @var string response status */
    private $status;

    /** @var array signature information structure */
    private $structure;

    /**
     * Fields expected in response
     */
    public function getFields(): array
    {
        return [
            'status',
            'structure',
        ];
    }

    /**
     * Get the value of status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Get the value of structure
     */
    public function getStructure(): ?array
    {
        return $this->structure;
    }

    /**
     * Set the value of structure
     */
    public function setStructure(array $structure): void
    {
        $this->structure = $structure;
    }
}
