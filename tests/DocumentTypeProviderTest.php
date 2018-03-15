<?php
namespace Isign\Gateway\Tests;

use Isign\Gateway\DocumentTypeProvider;

class DocumentTypeProviderTest extends TestCase
{
    public function testGetAllDocumentTypes()
    {

        $ref = new \ReflectionClass('Isign\Gateway\DocumentTypeProvider');
        $this->assertEquals(count($ref->getConstants()) - 1, count(DocumentTypeProvider::getAllDocumentTypes())); // -1 due to 'asic' not really being a separate file type
    }

    public function testGetPrimaryDocumentTypes()
    {
        $this->assertEquals(7, count(DocumentTypeProvider::getPrimaryDocumentTypes()));
    }
}
