<?php
namespace Isign\Gateway\Query\Signing;

use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\Signing\SealResult;
use Isign\Gateway\SigningPurposeProvider;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Upload a file to Gateway.
 */
class Seal implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /** @var string signing name */
    private $name;

    /** @var string Signing purpose */
    private $signing_purpose;

    /** @var string document type */
    private $type;

    /** @var array PDF-specific options */
    private $params;

    /**
     * @param string $token
     * @param string $name document name
     * @param string|null $signing_purpose optional
     * @param array|null $params Optional parameters per file type (currently only PDF params are supported)
     */
    public function __construct(
        string $token,
        string $name,
        ?string $signing_purpose = null,
        ?array $params = null
    ) {
        $this->token = $token;
        $this->name = $name;
        $this->signing_purpose = $signing_purpose;
        $this->params = $params;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        $return = [
            'token' => $this->token,
            'name' => $this->name,
        ];

        if ($this->signing_purpose !== null) {
            $return['signing_purpose'] = $this->signing_purpose;
        }

        if ($this->params !== null) {
            $return['pdf'] = $this->params;
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
            'token' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'name' => new Assert\Required([
                new Assert\NotBlank(),
            ]),
            'signing_purpose' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Choice([
                    'choices' => SigningPurposeProvider::getAllSigningPurposes(),
                ]),
            ]),
            'pdf' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Collection([
                    'annotation' => new Assert\Optional([
                        new Assert\NotBlank(),
                        new Assert\Collection([
                            'page' => new Assert\Optional([
                                new Assert\NotBlank(),
                                new Assert\Type([
                                    'type' => 'numeric',
                                ]),
                            ]),
                            'top' => new Assert\Optional([
                                new Assert\NotBlank(),
                                new Assert\Type([
                                    'type' => 'numeric',
                                ]),
                            ]),
                            'left' => new Assert\Optional([
                                new Assert\NotBlank(),
                                new Assert\Type([
                                    'type' => 'numeric',
                                ])
                            ]),
                            'width' => new Assert\Optional([
                                new Assert\NotBlank(),
                                new Assert\Type([
                                    'type' => 'numeric',
                                ])
                            ]),
                            'height' => new Assert\Optional([
                                new Assert\NotBlank(),
                                new Assert\Type([
                                    'type' => 'numeric',
                                ])
                            ]),
                            'text' => new Assert\Optional([
                                new Assert\NotBlank(),
                            ]),
                        ]),
                    ]),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return SealResult
     */
    public function createResult(): ResultInterface
    {
        return new SealResult();
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
