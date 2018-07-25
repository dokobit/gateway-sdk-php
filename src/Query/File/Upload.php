<?php
namespace Dokobit\Gateway\Query\File;

use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\File\UploadResult;
use Dokobit\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_file_upload
 */
class Upload implements QueryInterface
{
    use FileFieldsTrait;

    /** @var string path of the file to be uploded */
    private $path;

    /** @var string|null file name which will be sent to Gateway */
    private $filename;

    /**
     * @param string $path path of the file to be uploded
     * @param string|null $filename file name which will be sent to Gateway.
     *                    If null or not set, original file name will be sent.
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
            'file' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Collection([
                    'name' => new Assert\Required([
                        new Assert\NotBlank(),
                    ]),
                    'content' => new Assert\Required([
                        new Assert\NotBlank(),
                    ]),
                    'digest' => new Assert\Required([
                        new Assert\NotBlank(),
                    ]),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return UploadResult
     */
    public function createResult(): ResultInterface
    {
        return new UploadResult();
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
