<?php
namespace Isign\Gateway\Http;

use GuzzleHttp;
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
     * Send HTTP request
     * @param string $method POST|GET
     * @param string $url http URL
     * @param array $options query options. Query values goes under 'body' key.
     * Example:
     * $options = [
     *     'query' => [
     *         'access_token' => 'foobar',
     *     ],
     *     'body' => [
     *         'param1' => 'value1',
     *         'param2' => 'value2',
     *     ]
     * ]
     * @param bool $expectJson whether JSON response is expected
     * @return array
     */
    public function sendRequest(
        string $method,
        string $url,
        array $options = [],
        bool $expectJson = true
    ): array {
        $result = [];

        try {
            $response = $this->client->send(
                $this->client->createRequest($method, $url, $options)
            );
            if ($expectJson) {
                $result = $response->json();
            } else {
                $result = [ 'body' => $response->getBody() ];
            }
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

        return $result;
    }
}
