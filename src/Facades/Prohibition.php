<?php

namespace Joodek\Prohibition\Facades;

use Illuminate\Support\Facades\Facade;
use Joodek\Prohibition\LaravelProhibition;

/**
 * @method static void authorize(\Illuminate\Http\Request $request) authorize the incoming request
 * @method static bool banned(\App\Models\User $user = null,string $ip = null) check wether the user is banned
 */
class Prohibition extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelProhibition::class;
    }
}
