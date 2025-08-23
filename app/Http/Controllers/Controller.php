<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\HttpResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HttpResponses;

    public function fetchSettings()
    {
        return $this->successWithDataResponse(Setting::pluck('value', 'key'));
    }
}
