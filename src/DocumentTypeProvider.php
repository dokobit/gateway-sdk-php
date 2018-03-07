<?php

namespace Isign\Gateway;

abstract class DocumentTypeProvider
{
    const PDF = 'pdf';
    const PDFLT = 'pdflt';

    const ASICE = 'asice';

    const ADOC = 'adoc';
    const ADOC_BEDOC = 'adoc.bedoc';
    const ADOC_CEDOC = 'adoc.cedoc';
    const ADOC_GEDOC = 'adoc.gedoc';
    const ADOC_GGEDOC = 'adoc.ggedoc';

    const MDOC = 'mdoc';
    const MDOC_BEDOC = 'mdoc.bedoc';
    const MDOC_CEDOC = 'mdoc.cedoc';
    const MDOC_GEDOC = 'mdoc.gedoc';
    const MDOC_GGEDOC = 'mdoc.ggedoc';

    const BDOC = 'bdoc';

    const EDOC = 'edoc';

    final public static function getAllDocumentTypes()
    {
        return [
            self::PDF,
            self::PDFLT,
            self::ASICE,
            self::ADOC,
            self::ADOC_BEDOC,
            self::ADOC_CEDOC,
            self::ADOC_GEDOC,
            self::ADOC_GGEDOC,
            self::MDOC,
            self::MDOC_BEDOC,
            self::MDOC_CEDOC,
            self::MDOC_GEDOC,
            self::MDOC_GGEDOC,
            self::BDOC,
            self::EDOC
        ];
    }

    final public static function getPrimaryDocumentTypes()
    {
        return [
            self::PDF,
            self::ASICE,
            self::ADOC,
            self::MDOC,
            self::BDOC,
            self::EDOC
        ];
    }
}
