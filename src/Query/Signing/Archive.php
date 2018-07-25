<?php
namespace Dokobit\Gateway\Query\Signing;

use Dokobit\Gateway\Query\QueryInterface;
use Dokobit\Gateway\Result\ResultInterface;
use Dokobit\Gateway\Result\Signing\ArchiveResult;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Archive a signing.
 * @see https://gateway-sandbox.dokobit.com/api/doc#_api_signing_archive
 */
class Archive implements QueryInterface
{
    /** @var string signing token */
    private $token;

    /** @var string postback URL, if specified */
    private $postbackUrl;

    /**
     * @param string $token signing token
     * @param string|null $postbackUrl postback URL. If not specified here,
     *                    the one sent during signing creation will be used.
     */
    public function __construct(
        string $token,
        ?string $postbackUrl = null
    ) {
        $this->token = $token;
        $this->postbackUrl = $postbackUrl;
    }

    /**
     * Field and values association used in query
     * @return array
     */
    public function getFields(): array
    {
        $return = [
            'token' => $this->token,
        ];

        if ($this->postbackUrl !== null) {
            $return['postback_url'] = $this->postbackUrl;
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
            'postback_url' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Url(),
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
        return "signing/{$this->token}/archive";
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
