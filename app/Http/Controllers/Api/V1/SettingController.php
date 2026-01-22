<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function toggleMaintenance(Request $request){
        $request->validate(['status' => 'required|boolean']);

        if($request->status){
            \Artisan::call('down');
        } else {
            \Artisan::call('up');
        }

        return response()->json([
            'error' => false,
            'data' => [
                'message' => $request->status ? 'Maintenance mode enabled' : 'Maintenance mode disabled',
            ]
        ])->header('Retry-after', 3600);
    }
}
