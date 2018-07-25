<?php
namespace Dokobit\Gateway\Query\File;

use Dokobit\Gateway\DocumentTypeProvider;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\File\UploadStatusResult;
use Dokobit\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Check upload status.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_file_upload_status
 */
class UploadStatus implements QueryInterface
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
     * @return UploadStatusResult
     */
    public function createResult(): ResultInterface
    {
        return new UploadStatusResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "file/upload/{$this->token}/status";
    }

    /**
     * HTTP method to use
     * @return string
     */
    public function getMethod(): string
    {
        return QueryInterface::GET;
    }
}
