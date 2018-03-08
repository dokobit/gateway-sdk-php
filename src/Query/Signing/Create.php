<?php
namespace Isign\Gateway\Query\Signing;

use Isign\Gateway\DocumentTypeProvider;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\Signing\CreateResult;
use Isign\Gateway\SigningPurposeProvider;
use Isign\Gateway\Validator\Constraints as MyAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway.
 */
class Create implements QueryInterface
{
    const FILE_TYPE_MAIN = 'main';
    const FILE_TYPE_APPENDIX = 'appendix';
    const FILE_TYPE_ATTACHMENT = 'attachment';

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
                    'choices' => DocumentTypeProvider::getAllDocumentTypes(),
                ]),
            ]),
            'name' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'files' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\All([
                    new Assert\Collection([
                        'token' => new Assert\Required([
                            new Assert\NotBlank(),
                        ]),
                        'type' => new Assert\Optional([
                            new Assert\NotBlank(),
                            new Assert\Choice([
                                'choices' => [
                                    self::FILE_TYPE_MAIN,
                                    self::FILE_TYPE_APPENDIX,
                                    self::FILE_TYPE_ATTACHMENT,
                                ],
                            ]),
                        ]),
                    ]),
                ]),
            ]),
            'signers' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\All([
                    new Assert\Collection([
                        'name' => new Assert\Required([
                            new Assert\NotBlank(),
                        ]),
                        'surname' => new Assert\Required([
                            new Assert\NotBlank(),
                        ]),
                        'code' => new Assert\Optional([
                            new Assert\NotBlank(),
                            new MyAssert\Code(),
                        ]),
                        'phone' => new Assert\Optional([
                            new Assert\NotBlank(),
                            new MyAssert\Phone(),
                        ]),
                        'company' => new Assert\Optional([
                            new Assert\NotBlank(),
                        ]),
                        'country' => new Assert\Optional([
                            new Assert\NotBlank(),
                        ]),
                        'country_code' => new Assert\Optional([
                            new Assert\NotBlank(),
                            new Assert\Country(),
                        ]),
                        'city' => new Assert\Optional([
                            new Assert\NotBlank(),
                        ]),
                        'postal_code' => new Assert\Optional([
                            new Assert\NotBlank(),
                        ]),
                        'position' => new Assert\Optional([
                            new Assert\NotBlank(),
                        ]),
                        'structural_subdivision' => new Assert\Optional([
                            new Assert\NotBlank(),
                        ]),
                        'signing_purpose' => new Assert\Optional([
                            new Assert\NotBlank(),
                            new Assert\Choice([
                                'choices' => SigningPurposeProvider::getAllSigningPurposes(),
                            ]),
                        ]),
                        $this->type => new Assert\Optional(),
                    ]),
                ]),
            ]),
            'postback_url' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Url(),
            ]),
            'language' => new Assert\Optional(),
            $this->type => new Assert\Optional(),
        ]);
    }

    /**
     * Result object for this query result
     * @return CreateResult
     */
    public function createResult(): ResultInterface
    {
        return new CreateResult();
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
