<?php

namespace App\Http\Controllers;

use App\Models\Slave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $slaves = Slave::all();
        $events = json_encode(config('slave.events'));
        $levels = json_encode(config('slave.prices'));
        return view('dashboard', compact(['slaves', 'events', 'levels']));
    }

    public function follow(Request $request, $slave)
    {
        $followedSlave = Slave::where('follow', true)->first();
        if ($followedSlave) {
            $followedSlave->follow = false;
            $followedSlave->save();
        }
        $slave = Slave::find($slave);
        $slave->follow = true;
        $slave->save();

        return redirect()->back();
    }

    public function renderMap(Request $request)
    {
        $image = $request->file('image');

        Storage::put('public/' . $request->type . ".png", file_get_contents($image));
    }
}
