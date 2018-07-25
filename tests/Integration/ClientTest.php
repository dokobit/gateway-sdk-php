<?php
namespace Dokobit\Gateway\Tests\Integration;

class ClientTest extends TestCase
{
    const TEST_FILE_URL = 'https://developers.dokobit.com/sc/test.pdf';

    public function testFileDownload()
    {
        $path = tempnam(sys_get_temp_dir(), 'TEST');
        $this->assertStringEqualsFile($path, '', 'Test file must be empty before download!');

        $this->client->downloadFile(self::TEST_FILE_URL, $path);
        $this->assertStringNotEqualsFile($path, '', 'Test file must not be empty after download!');
    }
}
