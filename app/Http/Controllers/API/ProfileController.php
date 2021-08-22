<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\profile;

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
        $profile = Profile::first();

        if(!$profile) {
            $create = Profile::create([
                'description' => $request->description,
                'address' => $request->address,
                'whatsapp' => $request->whatsapp,
                'telegram' => $request->telegram,
                'youtube' => $request->youtube,
                'discord' => $request->discord,
                'linkedln' => $request->linkedln
            ]);

            return response()->json([
                'message' => 'Profile is created'
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Profile is already exist'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $profile = Profile::first();

        if($profile) {
            $create = $profile->update([
                'description' => $request->description,
                'address' => $request->address,
                'whatsapp' => $request->whatsapp,
                'telegram' => $request->telegram,
                'youtube' => $request->youtube,
                'discord' => $request->discord,
                'linkedln' => $request->linkedln
            ]);

            return response()->json([
                'message' => 'Profile is updated'
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Profile is not updated'
            ], 500);
        }
    }
}
