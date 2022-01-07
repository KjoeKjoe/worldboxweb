<?php

namespace App\Http\Controllers;

use App\Models\Slave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TwitchSlaveController extends Controller
{
    public function store(Request $request)
    {
        if (Slave::where('firstName', $request->twitch['user-id'])->first()) {
            return 'You are already in game!';
        }

        Slave::create([
            'firstName' => $request->twitch['user-id'],
            'nickname' => '[T] ' . $request->twitch['display-name'],
            'is_twitch' => true
        ]);

        return "Added to the server!";
    }
}
