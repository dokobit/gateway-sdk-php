<?php
namespace Isign\Gateway\Query\Signing;

use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\Signing\DeleteResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Delete a signing.
 * @see https://gateway-sandbox.isign.io/api/doc#_api_signing_delete
 */
class Delete implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /**
     * @param string $type signing token
     */
    public function __construct(
        string $token
    ) {
        $this->token = $token;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        return [
            'token' => $this->token,
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
        ]);
    }

    /**
     * Result object for this query result
     * @return DeleteResult
     */
    public function createResult(): ResultInterface
    {
        return new DeleteResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "signing/{$this->token}/delete";
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
