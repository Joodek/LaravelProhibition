<?php

namespace Cata\Prohibition\Facades;

use Cata\Prohibition\LaravelProhibition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Facade;
use \Illuminate\Support\Carbon;

/**
 * @method static void authorize(\Illuminate\Http\Request $request) authorize the incoming request
 * @method static bool banned(User $user = null,string $ip = null) check wether the user is banned
 * @method static bool banModel(User|Collection $user,Carbon $expired_at) ban one or collection of users
 * @method static bool unbanModel(User|Collection $user) unban one or collection of users
 * @method static bool banIP(string|array $ip,Carbon $expired_at) ban one or arraay of ips
 */
class Prohibition extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelProhibition::class;
    }
}
