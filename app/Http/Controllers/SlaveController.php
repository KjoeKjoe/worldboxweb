<?php

namespace App\Http\Controllers;

use App\Models\Slave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlaveController extends Controller
{
    public function store(Request $request)
    {
        return;
    }

    public function get()
    {
        //get slaves
        $slaves = Slave::where('spawned', false);
        //get dead slaves
        $deadSlaves = Slave::where('died', true);
        $slavesIsEmpty = $slaves->get()->isEmpty();
        $deadSlavesIsEmpty = $deadSlaves->get()->isEmpty();

        //check if there are no spawn left in both dead and not spawned
        if ($slavesIsEmpty && $deadSlaves->get()->isEmpty()) {
            return response('no spawns');
        }

        //get random slave from not spawned yet
        $slave = $slaves->inRandomOrder()->first();

        //if someone died we want to respawn them get them in random order
        if (!$deadSlavesIsEmpty) {
            $slave = $deadSlaves->inRandomOrder()->first();
            $slave->died = false;
        }
        //reset for fresh start
        $this->resetSlave($slave);

        //set spawn true since it will be spawned
        $slave->spawned = true;
        $slave->save();

        return $slave;
    }

    public function respawn(Request $request)
    {
        $slave = $request->get('slave');

        if ($slave->spawned && !$slave->died)  {
            return "You are already there!!!";
        }

        $slave->died = false;
        $slave->spawned = false;
        $slave->save();

        return "Look ingame! you are back in action!";
    }

    public function getCurrency(Request $request)
    {
        return response($request->get('slave')->currency, 200);
    }

    public function getShop(Request $request)
    {
        $prices = config('slave.prices');

        $string = "";

        foreach ($prices as $index => $price) {
            if ($index === 'equipment') {
                foreach ($price as $eIndex => $ePrice) {
                    $string .= "◙ " . ucfirst($eIndex) . " cost - " . $ePrice . "\n";
                }
            }
            if ($index === 'health') {
                $string .= "◙ " . ucfirst($index) . " cost - " . $price . " - increases skill + 10\n";
            }
            elseif ($index === 'respawn') {
                $string .= "◙ " . ucfirst($index) . " cost - " . $price . " - respawn back in action live!\n";
            }
            else {
                $string .= "◙ " . ucfirst($index) . " cost - " . json_encode($price) . "\n";
            }
        }

        return "Use ''!worldbox-buy-level **skill**'' to levelup your skill at spawn! \nThe shop prices are: \n" . $string;
    }

    public function all()
    {
        return [
            'data' => Slave::where('spawned', true)
                ->where('died', false)
                ->get()
        ];
    }

    public function died(Request $request)
    {
        $slave = Slave::where('firstName', $request->firstName)->first();

        if (!$slave) {
            return;
        }

        $slave->died = true;
        $slave->spawned = false;

        //reset slave to base
        $this->resetSlave($slave);

        $slave->save();
    }

    public function follow(Request $request)
    {
        $followedSlave = Slave::where('follow', true)->first();
        $followedSlave->follow = false;
        $followedSlave->save();


        $slave = $request->get('slave');
        $slave->follow = true;
        $slave->save();

        return "Let's watch you on the big screen";
    }

    public function setRace(Request $request)
    {
        $slave = $request->get('slave');
        $slave->race = $request->race;
        $slave->save();

        return "Changing your starter race to: " . $request->race;
    }

    public function setNickname(Request $request)
    {
        $slave = $request->get('slave');
        $slave->nickname = $request->nickname;
        $slave->save();

        return "Nickname set to: **" . $request->nickname . "**";
    }

    public function updateStats(Request $request)
    {
        $slave = Slave::where('firstName', $request->firstName)->first();

        $points = $this->getPoints($request);

        $currentStats = [
            'age' => $request->age,
            'kills' => $request->kills,
            'children' => $request->children,
            'health' => $request->health,
            'diplomacy' => $request->diplomacy,
            'warfare' => $request->warfare,
            'stewardship' => $request->stewardship,
            'intelligence' => $request->intelligence,
        ];


        //reset slave to base
        $slave->currency += $points;
        $slave->age = $request->age;
        $slave->kills = $request->kills;
        $slave->children = $request->children;
        $slave->health = $request->health;
        $slave->diplomacy = $request->diplomacy;
        $slave->warfare = $request->warfare;
        $slave->stewardship = $request->stewardship;
        $slave->intelligence = $request->intelligence;

        $slave->save();

        //put latest stats in temp json
        Storage::put('slaves/' . $request->firstName . '.json', json_encode($currentStats));
    }

    public function buyEquipment(Request $request)
    {
        $slave = $request->get('slave');

        $price = config('slave.prices.equipment.' . $request->material);
        if ($slave->currency < $price) {
            return "You don't have the currency to pay for it.";
        }
        $equipment = $request->equipment;

        $slave->currency -= $price;
        $slave->$equipment = $request->material;
        $slave->save();

        return "You are now the proud owner of an " . $request->material . " " . $equipment;
    }

    public function addLevel(Request $request)
    {
        $slave = $request->get('slave');

        $price = config('slave.prices.' . $request->level) * $request->amount;
        if ($slave->currency < $price) {
            return "You don't have the currency to pay for it.";
        }

        $level = 'base_' . $request->level;
        $addValue = $request->amount;

        if ($level === "base_health") {
            $addValue = 10;
            if ($request->amount !== 1) {
                $addValue = $request->amount * 10;
            }
        }

        $slave->currency -= $price;
        $slave->$level += $addValue;
        $slave->save();

        return "Congrats! your base skill has been leveled to: **" . $slave->$level . "**";
    }

    public function addTrait(Request $request)
    {
        $slave = $request->get('slave');
        $trait = $request->trait;

        $price = config('slave.prices.' . $trait);
        if ($slave->currency < $price) {
            return "You don't have the currency to pay for it.";
        }
        $ownedTraits = json_decode($slave->traits);

        if (in_array($trait, $ownedTraits->trait_data)) {
            return "you already own this trait";
        }

        if ($trait === "charged") {
            return "Charged is disabled, working on fix";
        }

        $ownedTraits->trait_data[] = $trait;

        $slave->currency -= $price;
        $slave->traits = json_encode($ownedTraits);
        $slave->save();

        return "Congrats! you now own the: **" . $request->trait . "** trait";
    }

    public function resetSlave($slave)
    {
        $slave->age = 1;
        $slave->kills = 0;
        $slave->children = 0;
        $slave->health = $slave->base_health;
        $slave->diplomacy = $slave->base_diplomacy;
        $slave->warfare = $slave->base_warfare;
        $slave->stewardship = $slave->base_stewardship;
        $slave->intelligence = $slave->base_intelligence;

        $slave->save();

        Storage::delete('slaves/' . $slave->firstName . '.json');
    }

    public function getPoints($request)
    {
        if (Storage::exists('slaves/' . $request->firstName . '.json')) {
            $previousStats = json_decode((Storage::get('slaves/' . $request->firstName . '.json')));
            //calculate discord rewards
            return $this->calculatePoints(
                $request->kills,
                $request->children,
                $request->age,
                $previousStats->kills,
                $previousStats->children,
                $previousStats->age
            );
        }
        return $this->calculatePoints(
            $request->kills,
            $request->children,
            $request->age,
        );
    }

    public function calculatePoints(
        $kills,
        $children,
        $age,
        $previousKills = 0,
        $previousChildren = 0,
        $previousAge = 0
    )
    {
        $points = (($kills - $previousKills) * config('slave.stat_score.kills')) +
            (($children - $previousChildren) * config('slave.stat_score.children')) +
            (($age - $previousAge) * config('slave.stat_score.age'));

        return $points;
    }
}
