<?php
namespace Isign\Gateway\Query;

use Isign\Gateway\DocumentTypeProvider;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\SigningSealResult;
use Isign\Gateway\SigningPurposeProvider;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway.
 */
class SigningSeal implements QueryInterface
{
    /** @var string signing document type */
    private $type;

    /** @var string signing name */
    private $name;

    /** @var string signing token */
    private $token;

    /** @var string document type-specific options */
    private $params;

    /** @var string postback URL, if specified */
    private $signing_purpose;

    /**
     * @param string $type document type
     * @param string $name document name
     * @param string $token
     * @param array|null $params Optional parameters per file type
     * @param string $signing_purpose optional
     */
    public function __construct(
        string $type,
        string $name,
        string $token,
        ?array $params = null,
        ?string $signing_purpose = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->token = $token;
        $this->params = $params;
        $this->signing_purpose = $signing_purpose;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        $return = [
            'name' => $this->name,
            'token' => $this->token,
        ];

        if ($this->params !== null) {
            $return[$this->type] = $this->params;
        }

        if ($this->signing_purpose !== null) {
            $return['signing_purpose'] = $this->signing_purpose;
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
            'name' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'token' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'signing_purpose' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Choice([
                    'choices' => SigningPurposeProvider::getAllSigningPurposes(),
                ]),
            ]),
            $this->type => new Assert\Optional([
                new Assert\Collection(),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return SigningSealResult
     */
    public function createResult(): ResultInterface
    {
        return new SigningSealResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "signing/{$this->token}/seal";
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
