<?php
namespace Dokobit\Gateway\Query\Signing;

use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\ResultInterface;
use Dokobit\Gateway\Result\Signing\SignResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sign a signing via API.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_signing_sign
 */
class Sign implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /** @var string signer id */
    private $signerId;

    /** @var string signature value */
    private $signatureValue;

    /**
     * @param string $token signing token
     * @param string $signerId signer id
     * @param string $signatureValue signature value
     */
    public function __construct(
        string $token,
        string $signerId,
        string $signatureValue
    ) {
        $this->token = $token;
        $this->signerId = $signerId;
        $this->signatureValue = $signatureValue;
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
            'signature_value' => $this->signatureValue,
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
            'signature_value' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return SignResult
     */
    public function createResult(): ResultInterface
    {
        return new SignResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "signing/{$this->token}/sign";
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
