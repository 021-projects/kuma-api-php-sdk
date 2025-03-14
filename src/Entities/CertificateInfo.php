<?php

namespace O21\KumaApi\Entities;

use O21\ApiEntity\BaseEntity;

/**
 * @property \O21\KumaApi\Entities\CertificateSubject $subject
 * @property \O21\KumaApi\Entities\CertificateIssuer $issuer
 * @property string $subjectaltname
 * @property array $infoAccess
 * @property int $bits
 * @property array $pubkey
 * @property string $asn1Curve
 * @property string $nistCurve
 * @property \Carbon\Carbon $validFrom
 * @property \Carbon\Carbon $validTo
 * @property string $fingerprint
 * @property string $fingerprint256
 * @property string $fingerprint512
 * @property string $extKeyUsage
 * @property string $serialNumber
 * ... todo: add more properties
 */
class CertificateInfo extends BaseEntity
{
}
