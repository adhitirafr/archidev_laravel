<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\profile;
use Auth, Log;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::first();

        return response()->json([
            'data' => $profile
        ], 200);
    }

    public function store(Request $request)
    {
        $create = Profile::updateOrcreate([
            'id' => 1
        ],[
            'description' => $request->description,
            'address' => $request->address,
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
            'youtube' => $request->youtube,
            'linkedln' => $request->linkedln,
        ]);

        return response()->json([
            'message' => 'Profile is created'
        ], 200);
        
    }
}
