<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HttpResponses;

class VersionController extends Controller
{
    use HttpResponses;

    public function getVersions()
    {
        $versions = Setting::whereIn('key', ['version', 'android_link', 'ios_link'])
            ->pluck('value', 'key');

        return $this->successWithDataResponse([
            'version'      => $versions->get('version'),
            'android_link' => $versions->get('android_link'),
            'ios_link'     => $versions->get('ios_link'),
        ]);
    }
}
