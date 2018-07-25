<?php
namespace Dokobit\Gateway\Tests;

use Dokobit\Gateway\DocumentTypeProvider;

class DocumentTypeProviderTest extends TestCase
{
    public function testGetAllDocumentTypes()
    {

        $ref = new \ReflectionClass('Dokobit\Gateway\DocumentTypeProvider');
        $this->assertEquals(count($ref->getConstants()) - 1, count(DocumentTypeProvider::getAllDocumentTypes())); // -1 due to 'asic' not really being a separate file type
    }

    public function testGetPrimaryDocumentTypes()
    {
        $this->assertEquals(7, count(DocumentTypeProvider::getPrimaryDocumentTypes()));
    }
}
