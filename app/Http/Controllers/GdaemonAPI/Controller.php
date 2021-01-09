<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('gdaemonVerifyApiToken');
    }
}
