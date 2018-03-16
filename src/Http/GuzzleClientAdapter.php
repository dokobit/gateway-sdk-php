<?php
namespace Isign\Gateway\Http;

use GuzzleHttp;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use Isign\Gateway\Exception;

/**
 * Adapter for GuzzleHttp client
 */
class GuzzleClientAdapter implements ClientInterface
{
    /** @var GuzzleHttp\ClientInterface */
    protected $client;

    /**
     * @param type GuzzleHttp\ClientInterface $client
     * @return self
     */
    public function __construct(GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send HTTP request and return response body
     * @param string $method POST|GET
     * @param string $url http URL
     * @param array $options query options. Query values goes under 'body' key.
     *         Example:
     *         $options = [
     *             'query' => [
     *                 'access_token' => 'foobar',
     *             ],
     *             'body' => [
     *                 'param1' => 'value1',
     *                 'param2' => 'value2',
     *             ]
     *         ]
     * @return string
     */
    public function requestBody(
        string $method,
        string $url,
        array $options = []
    ): ?string {
        $response = $this->sendRequest($method, $url, $options);

        return $response->getBody();
    }

    /**
     * Send HTTP request and return response JSON parsed into array
     * @param string $method POST|GET
     * @param string $url http URL
     * @param array $options query options. Query values goes under 'body' key.
     *         Example:
     *         $options = [
     *             'query' => [
     *                 'access_token' => 'foobar',
     *             ],
     *             'body' => [
     *                 'param1' => 'value1',
     *                 'param2' => 'value2',
     *             ]
     *         ]
     * @return array
     */
    public function requestJson(
        string $method,
        string $url,
        array $options = []
    ): ?array {
        $response = $this->sendRequest($method, $url, $options);

        return $response->json();
    }

    /**
     * Actually send the HTTP request and return its response object
     * @param string $method POST|GET
     * @param string $url http URL
     * @param array $options query options. Query values goes under 'body' key.
     *         Example:
     *         $options = [
     *             'query' => [
     *                 'access_token' => 'foobar',
     *             ],
     *             'body' => [
     *                 'param1' => 'value1',
     *                 'param2' => 'value2',
     *             ]
     *         ]
     * @return ResponseInterface
     */
    protected function sendRequest(
        string $method,
        string $url,
        array $options = [],
        bool $expectJson = true
    ): ResponseInterface {
        $result = [];

        try {
            $response = $this->client->send(
                $this->client->createRequest($method, $url, $options)
            );
            return $response;
        } catch (BadResponseException $e) {
            if ($e->getCode() == 400) {
                throw new Exception\InvalidData(
                    'Data validation failed',
                    400,
                    $e,
                    $e->getResponse()->json()
                );
            } elseif ($e->getCode() == 403) {
                throw new Exception\InvalidApiKey(
                    'Access forbidden. Invalid API key.',
                    403,
                    $e,
                    $e->getResponse()->getBody()
                );
            } elseif ($e->getCode() == 404) {
                throw new Exception\NotFound(
                    'Requested URL was not found.',
                    404,
                    $e,
                    $e->getResponse()->getBody()
                );
            } elseif ($e->getCode() == 500) {
                throw new Exception\ServerError(
                    'Error occurred on server side while handling request',
                    500,
                    $e,
                    $e->getResponse()->getBody()
                );
            } elseif ($e->getCode() == 504) {
                throw new Exception\Timeout(
                    'Request timeout',
                    504,
                    $e,
                    $e->getResponse()->getBody()
                );
            } else {
                throw new Exception\UnexpectedResponse(
                    'Unexpected error occurred',
                    $e->getCode(),
                    $e,
                    $e->getResponse()->getBody()
                );
            }
        } catch (\Exception $e) {
            throw new Exception\UnexpectedError('Unexpected error occurred', 0, $e);
        }
    }
}
