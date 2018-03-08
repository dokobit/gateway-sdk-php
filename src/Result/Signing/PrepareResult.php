<?php
namespace Isign\Gateway\Result\Signing;

use Isign\Gateway\Result\ResultInterface;

/**
 * Result object for signing/create response.
 */
class PrepareResult implements ResultInterface
{
    /** @var string response status */
    private $status;

    /** @var string dtbs */
    private $dtbs;

    /** @var string dtbs hash */
    private $dtbsHash;

    /** @var string algorithm */
    private $algorithm;

    /**
     * Fields expected in response
     * @return array
     */
    public function getFields()
    {
        return [
            'status',
            'dtbs',
            'dtbsHash',
            'algorithm',
        ];
    }

    /**
     * Get status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Get dtbs
     */
    public function getDtbs(): string
    {
        return $this->dtbs;
    }

    /**
     * Set dtbs
     */
    public function setDtbs(string $dtbs): void
    {
        $this->dtbs = $dtbs;
    }

    /**
     * Get the value of dtbsHash
     */
    public function getDtbsHash(): string
    {
        return $this->dtbsHash;
    }

    /**
     * Set the value of dtbsHash
     */
    public function setDtbsHash(string $dtbsHash): void
    {
        $this->dtbsHash = $dtbsHash;
    }

    /**
     * Get the value of algorithm
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * Set the value of algorithm
     */
    public function setAlgorithm(string $algorithm): void
    {
        $this->algorithm = $algorithm;
    }
}
