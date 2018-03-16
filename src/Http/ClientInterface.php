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
     * @return string|null
     */
    public function requestBody(string $method, string $url, array $options = []): ?string;

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
     * @return array|null
     */
    public function requestJson(string $method, string $url, array $options = []): ?array;
}
