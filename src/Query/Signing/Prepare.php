<?php
namespace Isign\Gateway\Query\Signing;

use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\Signing\PrepareResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prepare file for signing via API.
 */
class Prepare implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /** @var string signer id */
    private $signerId;

    /** @var string base64-encoded certificate */
    private $certificate;

    /**
     * @param string $token signing token
     * @param string $signerId signer id
     * @param string $certificate base64-encoded certificate
     */
    public function __construct(
        string $token,
        string $signerId,
        string $certificate
    ) {
        $this->token = $token;
        $this->signerId = $signerId;
        $this->certificate = $certificate;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        return [
            'token' => $this->token,
            'signer_id' => $this->signerId,
            'certificate' => $this->certificate,
        ];
    }

    /**
     * Validation constraints for request data validation
     * @return Assert\Collection
     */
    public function getValidationConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'token' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'signer_id' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'certificate' => new Assert\Optional([
                new Assert\NotBlank(),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return PrepareResult
     */
    public function createResult(): ResultInterface
    {
        return new PrepareResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "signing/{$this->token}/prepare";
    }

    /**
     * HTTP method to use
     * @return string
     */
    public function getMethod(): string
    {
        return QueryInterface::POST;
    }
}
