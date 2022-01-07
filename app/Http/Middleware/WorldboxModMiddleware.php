<?php

namespace App\Http\Middleware;

use App\Models\Slave;
use Closure;
use Illuminate\Http\Request;

class WorldboxModMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($request->discordUser['username']) && !Slave::where('firstName', $request->discordUser['username'] . '#' . $request->discordUser['discriminator'])->first()) {
            Slave::create([
                'firstName' => $request->discordUser['username'] . '#' . $request->discordUser['discriminator'],
                'nickname' => '[D] ' . $request->discordUser['username']
            ]);
        }

        if (isset($request->discordUser))
        {
            $slave = Slave::where('firstName', $request->discordUser['username'] . '#' . $request->discordUser['discriminator'])->first();
            $request->attributes->add(['slave'=> $slave]);
            $request->attributes->add(['nickname'=> '[D] ' . $request->discordUser['username']]);
        }

        if (isset($request->twitch)) {
            $slave = Slave::where('firstName', $request->twitch['user-id'])->first();
            $request->attributes->add(['firstName'=> $request->twitch['user-id']]);
            $request->attributes->add(['nickname'=> '[T] ' . $request->twitch['display-name']]);
            $request->attributes->add(['is_twitch'=> true]);
            $request->attributes->add(['slave'=> $slave]);
        }

        return $next($request);
    }
}
