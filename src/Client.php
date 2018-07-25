<?php

namespace Isign\Gateway;

use Isign\Gateway\Http\ClientInterface;
use Isign\Gateway\Http\GuzzleClientAdapter;
use Isign\Gateway\Query\QueryInterface;
use Isign\Gateway\Result\ResultInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

/**
 * ISIGN Gateway client
 */
class Client
{
    /** @var boolean use sandbox */
    private $sandbox = false;

    /** @var string API access key, provided by ISIGN administrators */
    private $apiKey = null;

    /** @var string production API URL */
    private $url = 'https://gateway.isign.io';

    /** @var string sandbox mode API URL. Used if $sandbox is true */
    private $sandboxUrl = 'https://gateway-sandbox.isign.io';

    /** @var ClientInterface HTTP client */
    private $client;

    /** @var ResponseMapperInterface response to result object mapper */
    private $responseMapper;

    /** @var ValidatorInterface Query validator */
    private $validator;
    /**
     * @param ClientInterface $client
     * @param ResponseMapperInterface $responseMapper
     * @param ValidatorInterface $validator
     * @param array $options
     * @return self
     */
    public function __construct(
        ClientInterface $client,
        ResponseMapperInterface $responseMapper,
        ValidatorInterface $validator,
        array $options = []
    ) {
        $this->validateOptions($options);
        $this->prepareOptions($options);

        $this->client = $client;
        $this->responseMapper = $responseMapper;
        $this->validator = $validator;
    }


    /**
     * Public factory method to create instance of Client.
     *
     * @param array $options Available properties: [
     *     'apiKey' => 'xxxxxx',
     *     'sandbox' => true,
     *     'url' => 'https://gateway.isign.io',
     *     'sandboxUrl' => 'https://gateway-sandbox.isign.io',
     * ]
     * @param LoggerInterface|null $logger Logger used to log
     *     messages. Pass a LoggerInterface to use a PSR-3 logger.
     *     Pass null or leave empty to disable logging.
     * @return self
     */
    public static function create(array $options = [], LoggerInterface $logger = null)
    {
        $client = new \GuzzleHttp\Client();

        if ($logger !== null) {
            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $logger,
                    new MessageFormatter()
                )
            );

            $client = new \GuzzleHttp\Client(
                [
                    'handler' => $stack,
                ]
            );
        }

        return new self(
            new GuzzleClientAdapter($client),
            new ResponseMapper(),
            Validation::createValidator(),
            $options
        );
    }

    /**
     * Get result by given query object
     * @param QueryInterface $query
     * @return ResultInterface
     */
    public function get(QueryInterface $query): ResultInterface
    {
        $this->validate($query);
        $fields = $query->getFields();

        return $this->responseMapper->map(
            $this->request(
                $query->getMethod(),
                $this->getFullMethodUrl($query->getAction()),
                $fields
            ),
            $query->createResult()
        );
    }

    /**
     * Check if sandbox enabled
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * Get API access key
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set API access key
     * @var $apiKey string
     */
    public function setApiKey($apiKey)
    {
        return $this->apiKey = $apiKey;
    }

    /**
     * Get production API URL
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get sandbox API URL
     * @return string
     */
    public function getSandboxUrl()
    {
        return $this->sandboxUrl;
    }

    /**
     * Get the base URL used for all calls.
     */
    public function getBaseUrl(): string
    {
        return $this->sandbox ? $this->sandboxUrl : $this->url;
    }

    /**
     * Get full API method URL by given action and token.
     * Checks if sandbox is enabled, then uses $sandboxUrl, otherwise
     * uses $url
     * @param string $action
     * @return string
     */
    public function getFullMethodUrl(string $action)
    {
        return $this->getBaseUrl() . '/api/' . $action . '.json';
    }

    /**
     * Get the URL for viewing uploaded file in a frame/modal.
     *
     * @param string $token File token returned by the Upload action.
     * @return string
     */
    public function getOpenUrl(string $token): string
    {
        $url = $this->getBaseUrl();

        return $url . '/open/' . $token;
    }

    /**
     * Get the URL for user to sign the file in a frame/modal.
     *
     * @param string $token File token returned by the Upload action.
     * @param string $accessToken User access token returned by the Addsigner action.
     * @return string
     */
    public function getSigningUrl(string $token, string $accessToken): string
    {
        $url = $this->getBaseUrl();

        return $url . '/signing/' . $token . '?access_token=' . $accessToken;
    }

    /**
     * Get the URL for signing multiple documents in a frame/modal with one action using a Smart Card.
     *
     * @param string $token Batch signing token returned by the Createbatch action.
     * @return string
     */
    public function getBatchSigningUrl(string $token): string
    {
        $url = $this->getBaseUrl();

        return $url . '/signing/batch/' . $token;
    }

    /**
     * Get the URL for signing multiple documents in a frame/modal in sequence.
     *
     * @param string $token Batch signing token returned by the Createbatch action.
     */
    public function getSequenceSigningUrl(string $token): string
    {
        $url = $this->getBaseUrl();

        return $url . '/signing/sequence/' . $token;
    }

    /**
     * Download signed file from a given URL and place it in the specified path.
     *
     * @param string $url URL to download.
     * @param string $path Path to download the file to.
     * @param bool $sendAccessToken Set this to false if you do not want access token appended to the URL automatically.
     *             Defaults to true.
     */
    public function downloadFile(
        string $url,
        string $path,
        bool $sendAccessToken = true
    ): void {
        if ($sendAccessToken) {
            $url .= '?access_token=' . $this->apiKey;
        }

        $this->client->requestBody(QueryInterface::GET, $url, ['save_to' => $path]);
    }

    /**
     * Handle request options and perform HTTP request using HTTP client.
     * @param string $method
     * @param string $url
     * @param array $fields
     * @return array|null
     */
    private function request(string $method, string $url, array $fields): ?array
    {

        $options = [
            'query' => [
                'access_token' => $this->getApiKey()
            ],
            'json' => $fields,
        ];

        return $this->client->requestJson($method, $url, $options);
    }

    /**
     * Read options from array and set values as object properties
     * @param array $options
     * @return void
     */
    private function prepareOptions(array $options): void
    {
        if (isset($options['sandbox'])) {
            $this->sandbox = (bool)$options['sandbox'];
        }
        if (isset($options['apiKey'])) {
            $this->apiKey = (string)$options['apiKey'];
        }
        if (isset($options['url'])) {
            $this->url = rtrim($options['url'], '/');
        }
        if (isset($options['sandboxUrl'])) {
            $this->sandboxUrl = rtrim($options['sandboxUrl'], '/');
        }
    }

    /**
     * Validate options
     * @param array $options
     * @return void
     * @throws InvalidApiKey if no API key given
     */
    private function validateOptions(array $options): void
    {
        if (empty($options['apiKey'])) {
            throw new Exception\InvalidApiKey('Access forbidden. Invalid API key.', 0);
        }
    }

    /**
     * Validate query parameters
     * @param QueryInterface $query
     * @return void
     */
    private function validate(QueryInterface $query): void
    {
        $violations = $this->validator->validate(
            $query->getFields(),
            $query->getValidationConstraints()
        );

        if (count($violations) !== 0) {
            throw new Exception\QueryValidator('Query parameters validation failed', $violations);
        }
    }
}
