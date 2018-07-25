<?php
namespace Dokobit\Gateway\Query\File;

use Dokobit\Gateway\DocumentTypeProvider;
use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\File\CheckResult;
use Dokobit\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Check validity of a signed file.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_file_check
 */
class Check implements QueryInterface
{
    use FileFieldsTrait;

    /** @var string intended type of the archived document */
    private $type;

    /** @var string path of the file to be uploded */
    private $path;

    /**
     * @param string $type intended type of the signed file
     * @param string $path path of the file to be uploded
     */
    public function __construct(
        string $type,
        string $path
    ) {
        $this->type = $type;
        $this->path = $path;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        return [
            'type' => $this->type,
            'file' => $this->getFileFields($this->path),
        ];
    }

    /**
     * Validation constraints for request data validation
     * @return Assert\Collection
     */
    public function getValidationConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'type' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Choice([
                    'choices' => DocumentTypeProvider::getPrimaryDocumentTypes(),
                ]),
            ]),
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
     * @return CheckResult
     */
    public function createResult(): ResultInterface
    {
        return new CheckResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return 'file/check';
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
