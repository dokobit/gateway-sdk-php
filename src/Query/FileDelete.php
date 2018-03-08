<?php
namespace Isign\Gateway\Query;

use Isign\Gateway\DocumentTypeProvider;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\FileDeleteResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Check upload status.
 */
class FileDelete implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /**
     * @param string $token
     */
    public function __construct(string $token) {
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
     * @return FileDeleteResult
     */
    public function createResult(): ResultInterface
    {
        return new FileDeleteResult();
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
