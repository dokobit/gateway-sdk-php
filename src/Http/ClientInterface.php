<?php
namespace Isign\Gateway\Http;

interface ClientInterface
{
    /**
     * Send HTTP request
     * @param string $method POST|GET
     * @param string $url http URL
     * @param array $options query options. Query params goes under 'query' key.
     * Example:
     * $options = [
     *     'query' => [
     *         'param1' => 'value1',
     *         'param2' => 'value2',
     *     ]
     * ]
     * @param bool $expectJson whether JSON response is expected
     * @return array
     */
    public function sendRequest(string $method, string $url, array $options = [], bool $expectJson = true);
}
