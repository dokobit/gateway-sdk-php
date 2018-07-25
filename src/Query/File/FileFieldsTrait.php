<?php
namespace Dokobit\Gateway\Query\File;

trait FileFieldsTrait
{
    /**
     * Get file fields for API query
     * @param string $path file path
     * @return array
     */
    public function getFileFields($path)
    {
        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf('File "%s" does not exist', $path));
        }

        $content = file_get_contents($path);

        return [
            'name' => basename($path),
            'digest' => sha1($content),
            'content' => base64_encode($content)
        ];
    }

    /**
     * Get multiple file fileds for API query by parsing list of file paths
     * @param array $files file paths
     * @return array
     */
    public function getMultipleFileFields(array $files)
    {
        $return = [];

        foreach ($files as $path) {
            $return[] = $this->getFileFields($path);
        }

        return $return;
    }
}
