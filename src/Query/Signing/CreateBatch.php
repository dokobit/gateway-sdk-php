<?php
namespace Isign\Gateway\Query\Signing;

use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\Signing\CreateBatchResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Create a batch signing.
 */
class CreateBatch implements QueryInterface
{
    /** @var array an array of associative arrays of signing and signer tokens. Format:
     *       [
     *           ['token' => 'signingToken1', 'signer_token' => 'signerToken1'],
     *           ['token' => 'signingToken2', 'signer_token' => 'signerToken2']
     *       ]
     */
    private $signings;

    /**
     * @param array $signingTokens
     * @param array $signerTokens
     */
    public function __construct(array $signings)
    {
        $this->signings = $signings;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        $return = [
            'signings' => $this->signings,
        ];

        return $return;
    }

    /**
     * Validation constraints for request data validation
     * @return Assert\Collection
     */
    public function getValidationConstraints(): Assert\Collection
    {
        return new Assert\All([
            new Assert\Collection([
                'token' => new Assert\Required([
                    new Assert\NotBlank()
                ]),
                'signer_token' => new Assert\Optional([
                    new Assert\NotBlank(),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return CreateBatchResult
     */
    public function createResult(): ResultInterface
    {
        return new CreateBatchResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return 'signing/createbatch';
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
