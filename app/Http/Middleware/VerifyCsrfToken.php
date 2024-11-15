<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'telemedicine/sync/tsekap',
        'api/refer/patient',
        'mobile/v2/login',
        'mobile/get/v2/facility',
        'mobile/get/v2/province',
        'mobile/get/v2/municipality',
        'mobile/get/v2/barangay',
        'mobile/get/v2/reason_for_referral',
        'mobile/get/v2/icd10',
        'file_upload',
        'bHDMSB83RwoznXAcnnC6aFtqiL1djvJs/api/data',
        'xZzl92SjyZPkGQOaLzsQhE9PFIvfjmil/api/check/username',
        'api/video/examined',
        'api/video/prescription/update',
        '/api/video/upward'
    ];
}
