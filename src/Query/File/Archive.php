<?php
namespace Isign\Gateway\Query\File;

use Isign\Gateway\DocumentTypeProvider;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\File\ArchiveResult;
use Isign\Gateway\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Archive a signed file.
 */
class Archive implements QueryInterface
{
    use FileFieldsTrait;

    /** @var string intended type of the archived document */
    private $type;

    /** @var string path of the file to be uploded, or a token of an already uploaded file */
    private $path;

    /** @var bool if true: $path will be treated as token, if false: $path is a path to file */
    private $pathIsToken;

    /**
     * @param string $type intended type of the signed file
     * @param string $path path of the file to be uploded, or a token of an already uploaded file
     * @param bool $pathIsToken if true, $path if is as a token (defaults to false)
     */
    public function __construct(
        string $type,
        string $path,
        bool $pathIsToken = false
    ) {
        $this->type = $type;
        $this->path = $path;
        $this->pathIsToken = $pathIsToken;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        return [
            'type' => $this->type,
            'file' => $this->pathIsToken ?
                [ 'token' => $this->path ] :
                $this->getFileFields($this->path),
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
                    'choices' => DocumentTypeProvider::getAllDocumentTypes(),
                ]),
            ]),
            'file' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Collection([
                    'token' => new Assert\Optional([
                        new Assert\NotBlank(),
                    ]),
                    'name' => new Assert\Optional([
                        new Assert\NotBlank(),
                    ]),
                    'content' => new Assert\Optional([
                        new Assert\NotBlank(),
                    ]),
                    'digest' => new Assert\Optional([
                        new Assert\NotBlank(),
                    ]),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return ArchiveResult
     */
    public function createResult(): ResultInterface
    {
        return new ArchiveResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return 'archive';
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
