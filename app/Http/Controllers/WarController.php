<?php

namespace App\Http\Controllers;

use App\Models\Slave;
use App\Models\War;
use Illuminate\Http\Request;

class WarController extends Controller
{
    public function war(Request $request)
    {
        $player2 = $this->getSecondPlayer($request->player);
        if (!$player2) {
            return "player not found";
        }
        War::create(
            [
                'player1' => $request->get('slave')->firstName,
                'player2' => $player2,
                'type' => 'war'
            ]
        );

        return "War has been set! you shall see it soon!";
    }
    public function peace(Request $request)
    {
        $player2 = $this->getSecondPlayer($request->player);
        if (!$player2) {
            return "player not found";
        }
        War::create(
            [
                'player1' => $request->get('slave')->firstName,
                'player2' => $player2,
                'type' => 'peace'
            ]
        );

        return "Peace has been set! you shall see it soon!";
    }

    public function getSecondPlayer($player)
    {
        if (str_starts_with($player, "@")){
            $player2 = substr($player, 1);

            $twitchExist = Slave::where('nickname', '[T] ' . $player2)->first();
            if ($twitchExist) {
                return $twitchExist->firstName;
            }
            $discordExist = Slave::where('nickname', '[D] ' . $player2)->first();
            if ($discordExist) {
                return $discordExist->firstName;
            }
        }
        if ($discord = Slave::where('nickname', '[D] ' . $player)->first()) {
            return $discord->firstName;
        }
        return 0;
    }

    public function getCmd(Request $request)
    {
        $cmd = War::all()->first();
        if ($cmd) {
            $returnCmd = new \stdClass();
            $returnCmd->player1 = $cmd->player1;
            $returnCmd->player2 = $cmd->player2;
            $returnCmd->type = $cmd->type;

            $cmd->delete();
            return $returnCmd;
        }
        return 'no cmd';
    }
}
