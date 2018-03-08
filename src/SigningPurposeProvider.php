<?php

namespace Isign\Gateway;

abstract class SigningPurposeProvider
{
    const SIGNING_PURPOSE_SIGNATURE  = 'signature';
    const SIGNING_PURPOSE_CONFIRMATION = 'confirmation';
    const SIGNING_PURPOSE_VISA = 'visa';
    const SIGNING_PURPOSE_CONCILIATION = 'conciliation';
    const SIGNING_PURPOSE_REGISTRATION = 'registration';
    const SIGNING_PURPOSE_REGISTRATION_OF_INCOMING_DOCUMENTS = 'registration-of-incoming-documents';
    const SIGNING_PURPOSE_ACKNOWLEDGEMENT = 'acknowledgement';
    const SIGNING_PURPOSE_NOTARISATION = 'notarisation';
    const SIGNING_PURPOSE_COPY_CERTIFICATION = 'copy-certification';

    final public static function getAllSigningPurposes()
    {
        return [
            self::SIGNING_PURPOSE_SIGNATURE ,
            self::SIGNING_PURPOSE_CONFIRMATION,
            self::SIGNING_PURPOSE_VISA,
            self::SIGNING_PURPOSE_CONCILIATION,
            self::SIGNING_PURPOSE_REGISTRATION,
            self::SIGNING_PURPOSE_REGISTRATION_OF_INCOMING_DOCUMENTS,
            self::SIGNING_PURPOSE_ACKNOWLEDGEMENT,
            self::SIGNING_PURPOSE_NOTARISATION,
            self::SIGNING_PURPOSE_COPY_CERTIFICATION,
        ];
    }
}
