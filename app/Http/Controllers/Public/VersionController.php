<?php

namespace App\Http\Controllers\Public;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;

class VersionController extends Controller
{
    use HttpResponses;

    public function getVersions()
    {
        $versions = Setting::whereIn('key', ['android_version', 'ios_version'])
            ->pluck('value', 'key');

        return $this->successWithDataResponse([
            'android_version' => $versions->get('android_version', '1.0.0'),
            'ios_version' => $versions->get('ios_version', '1.0.0'),
        ]);
    }
}
