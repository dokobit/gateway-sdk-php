<?php
namespace Isign\Gateway\Query\File;

use Isign\Gateway\DocumentTypeProvider;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\File\DeleteResult;
use Isign\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Check upload status.
 * @see https://gateway-sandbox.isign.io/api/doc#_api_file_delete
 */
class Delete implements QueryInterface
{
    /** @var string uploaded file token */
    private $token;

    /**
     * @param string $token uploaded file token
     */
    public function __construct(string $token)
    {
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
        return "file/{$this->token}/delete";
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
