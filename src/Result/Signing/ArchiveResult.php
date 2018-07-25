<?php
namespace Dokobit\Gateway\Result\Signing;

use Dokobit\Gateway\Result\ResultInterface;

/**
 * Result object for signing/{token}/archive response.
 */
class ArchiveResult implements ResultInterface
{
    /** @var string response status */
    private $status;

    /**
     * Fields expected in response
     */
    public function getFields(): array
    {
        return [
            'status',
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
}
