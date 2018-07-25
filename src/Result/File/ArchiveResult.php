<?php
namespace Dokobit\Gateway\Result\File;

use Dokobit\Gateway\Result\ResultInterface;

/**
 * Result object for archive response.
 */
class ArchiveResult implements ResultInterface
{
    /** @var string response status */
    private $status;

    /** @var array file contents and information */
    private $file;

    /** @var array signature information structure */
    private $structure;

    /**
     * Fields expected in response
     */
    public function getFields(): array
    {
        return [
            'status',
            'file',
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
     * Get the value of file
     */
    public function getFile(): array
    {
        return $this->file;
    }

    /**
     * Set the value of file
     */
    public function setFile(array $file): void
    {
        $this->file = $file;
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
