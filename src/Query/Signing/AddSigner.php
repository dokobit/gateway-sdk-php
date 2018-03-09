<?php
namespace Isign\Gateway\Query\Signing;

use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Isign\Gateway\Result\Signing\AddSignerResult;
use Isign\Gateway\SigningPurposeProvider;
use Isign\Gateway\Validator\Constraints as MyAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Add new signers to signing.
 */
class AddSigner implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /** @var string information about document signers */
    private $signers;

    /**
     * @param string $token signing token
     * @param array $signers information about document signers
     */
    public function __construct(
        string $token,
        array $signers
    ) {
        $this->token = $token;
        $this->signers = $signers;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        return [
            'token' => $this->token,
            'signers' => $this->signers,
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
            'signers' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\All([
                    new Assert\Collection([
                        'id' => new Assert\Required([
                            new Assert\NotBlank(),
                        ]),
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
                        'pdf' => new Assert\Optional(),
                        'pdflt' => new Assert\Optional(),
                        'adoc' => new Assert\Optional(),
                        'mdoc' => new Assert\Optional(),
                    ]),
                ]),
            ]),
        ]);
    }

    /**
     * Result object for this query result
     * @return AddSignerResult
     */
    public function createResult(): ResultInterface
    {
        return new AddSignerResult();
    }

    /**
     * API action name, part of full API request url
     * @return string
     */
    public function getAction(): string
    {
        return "signing/{$this->token}/addsigner";
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
