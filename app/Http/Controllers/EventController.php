<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $event = ucfirst($request->event);

        if ($event === 'mad-thoughts' || $event === 'evil-mage') {
            $explode = explode('-', $event);
            $event = ucfirst($explode[0]) . ' ' . ucfirst($explode[1]);
        }

        $price = config('slave.events.' . $event . '.price');

        if ($request->amount >= 1) {
            $price = $price * $request->amount;
        }

        $slave = $request->get('slave');
        if ($slave->currency < $price) {
            return "You don't have the currency to pay for it.";
        }
        $slave->currency -= $price;
        $slave->save();

        $times =  $request->amount;
        if ($request->amount === 0) {
            $times = 1;
        }

        Event::create(
            [
                'event' => $event,
                'times' => $times
            ]
        );

        return "Soon the events will stow upon the world!";
    }

    public function get() {
        $event = Event::first();

        if ($event) {
            $returnEvent = new \stdClass();
            $returnEvent->eventName = $event->event;
            $returnEvent->times = $event->times;
            $returnEvent->type = $event->type;

            $event->delete();
            return $returnEvent;
        }
        return "no event";
    }
}
