<?php
namespace Isign\Gateway\Query;

use Isign\Gateway\Result\FileUploadResult;
use Isign\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway.
 */
class FileUpload implements QueryInterface
{
    use FileFieldsTrait;

    /** @var string path of the file to be uploded */
    private $path;

    /** $var string|null file name which should be sent to Gateway */
    private $filename;

    /**
     * @param string $path path of the file to be uploded
     * @param ?string $filename file name which should be sent to Gateway
     */
    public function __construct(string $path, ?string $filename = null)
    {
        $this->path = $path;
        $this->filename = $filename;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        $fileFields = $this->getFileFields($this->path);

        if ($this->filename !== null) {
            $fileFields['name'] = basename($this->filename);
        }

        $return = [
            'file' => $fileFields,
        ];

        return $return;
    }

    /**
     * Validation constraints for request data validation
     * @return Assert\Collection
     */
    public function getValidationConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'file' => new Assert\Required(
                [new Assert\NotBlank()]
            ),
            'filename' => new Assert\Optional(
                [new Assert\NotBlank()]
            ),
        ]);
    }

    /**
     * Result object for this query result
     * @return FileUploadResult
     */
    public function createResult(): ResultInterface
    {
        return new FileUploadResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return 'file/upload';
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
