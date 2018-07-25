<?php
namespace Dokobit\Gateway\Query\Signing;

use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\ResultInterface;
use Dokobit\Gateway\Result\Signing\RemoveSignerResult;
use Dokobit\Gateway\Validator\Constraints as MyAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Remove signers from signing.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_signing_removesigner
 */
class RemoveSigner implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /** @var array information about document signers */
    private $signers;

    /**
     * @param string $token signing token
     * @param array $signers information about document signers
     */
    public function __construct(
        string $token,
        array $signers
    ) {
        $this->token = $token;
        $this->signers = $signers;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        return [
            'token' => $this->token,
            'signers' => $this->signers,
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
            'signers' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\All([
                    new Assert\Collection([
                        'id' => new Assert\Required([
                            new Assert\NotBlank(),
                        ]),
                    ]),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return RemoveSignerResult
     */
    public function createResult(): ResultInterface
    {
        return new RemoveSignerResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "signing/{$this->token}/removesigner";
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
