<?php
namespace Dokobit\Gateway;

use Dokobit\Gateway\Result\ResultInterface;

/**
 * Mapping response array to result objects
 */
class ResponseMapper implements ResponseMapperInterface
{
    /**
     * @param array           $response
     * @param ResultInterface $result
     *
     * @return ResultInterface
     */
    public function map(array $response, ResultInterface $result): ResultInterface
    {
        foreach ($result->getFields() as $field) {
            $this->mapField($field, $response, $result);
        }

        return $result;
    }

    /**
     * Map single field from response to result object. Omit the fields which
     * are not present in response array.
     * @param string $field
     * @param array $response
     * @param ResultInterface $result
     * @return void
     */
    protected function mapField($field, array $response, ResultInterface $result)
    {
        if (!isset($response[$field])) {
            return;
        }
        $method = 'set' . $this->toMethodName($field);
        $result->$method($response[$field]);
    }

    /**
     * Convert value to camel case method name with first capital letter
     * @param string $value
     * @return string
     */
    protected function toMethodName($value)
    {
        $parts = explode('_', $value);
        $parts = array_map('ucfirst', $parts);

        return implode('', $parts);
    }
}
