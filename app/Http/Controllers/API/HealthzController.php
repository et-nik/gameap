<?php

namespace Gameap\Http\Controllers\API;

use Illuminate\Support\Facades\DB;

class HealthzController
{
    public function index()
    {
        try {
            DB::select('SELECT 1');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database connection error',
            ], 500);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'ok',
            'version' => config('constants.AP_VERSION'),
            'date' => config('constants.AP_DATE'),
        ]);
    }
}
