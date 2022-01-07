<?php

namespace App\Http\Controllers;

use App\Models\Slave;
use Illuminate\Http\Request;

class RevoltController extends Controller
{
    public function store(Request $request): string
    {
        $slave = $request->get('slave');
        $slave->revolt = true;
        $slave->save();

        return "A revolt will stow upon the kingdom soon!";
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return Slave::where('revolt', true)->get();
    }
}
