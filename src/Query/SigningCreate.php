<?php
namespace Isign\Gateway\Query;

use Isign\Gateway\DocumentTypeProvider;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\SigningCreateResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway.
 */
class SigningCreate implements QueryInterface
{
    /** @var string signing document type */
    private $type;

    /** @var string signing name */
    private $name;

    /** @var string tokens and other information about the douments to be signed */
    private $files;

    /** @var string information about document signers */
    private $signers;

    /** @var string postback URL, if specified */
    private $posbackUrl;

    /** @var string preferred Gateway UI language, if specified */
    private $language;

    /** @var string document type-specific options */
    private $params;

    /**
     * @param string $type document type
     * @param string $name document name
     * @param array $files tokens and other information about the documents to be signed
     * @param array $signers information about document signers
     * @param string $postbackUrl postback URL
     * @param string $language language to be used when communicating with the signer
     * @param string $params Optional parameters per file type
     */
    public function __construct(
        string $type,
        string $name,
        array $files,
        array $signers,
        ?string $postbackUrl = null,
        ?string $language = null,
        ?array $params = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->files = $files;
        $this->signers = $signers;
        $this->postbackUrl = $postbackUrl;
        $this->language = $language;
        $this->params = $params;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        $return = [
            'type' => $this->type,
            'name' => $this->name,
            'files' => $this->files,
            'signers' => $this->signers,
        ];

        if ($this->postbackUrl !== null) {
            $return['postback_url'] = $this->postbackUrl;
        }

        if ($this->language !== null) {
            $return['language'] = $this->language;
        }

        if ($this->params !== null) {
            $return[$this->type] = $this->params;
        }

        return $return;
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
                    'choices' => DocumentTypeProvider::getAllDocumentTypes()
                ]),
            ]),
            'name' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'files' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Type('array'),
            ]),
            'signers' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Type('array'),
            ]),
            'postback_url' => new Assert\Optional(),
            'language' => new Assert\Optional(),
            $this->type => new Assert\Optional(),
        ]);
    }

    /**
     * Result object for this query result
     * @return SigningCreateResult
     */
    public function createResult(): ResultInterface
    {
        return new SigningCreateResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return 'signing/create';
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
