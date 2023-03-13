<?php

namespace Joodek\Prohibition;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Joodek\Prohibition\Models\Ban;

class LaravelProhibition
{

    public function authorize(Request $request): void
    {
        if (config("prohibition.restrict"))
            abort_if(
                $this->banned($request->user(), $request->ip()),
                config("prohibition.error.code", 403),
                config("prohibition.error.message", "Forbidden")
            );
    }


    public function banned(User $user = null, string $ip = null): bool
    {
        if (is_null($user) && is_null($ip)) return false;

        $banned = Ban::query();

        if ($user) $banned->whereUserId($user->id);

        if ($ip) $banned->orWhere('ip', $ip);

        $banned = $banned->first();

        if (is_null($banned)) return false;

        if (!is_null($ex = $banned->expired_at) && $ex <= now()) {
            $banned->delete();
            return false;
        }

        return true;
    }


    public function banModel(User|Collection $user, ?Carbon $expired_at = null): bool
    {
        if ($user instanceof Collection) {
            return $user->map(
                fn ($usr) => $this->banModel($usr, $expired_at)
            )->first();
        }

        try {
            Ban::updateOrCreate(
                ["user_id" => $user->id],
                ["expired_at" => $expired_at]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    public function unbanModel(User|Collection $user): bool
    {
        $users = $user instanceof Collection
            ?    $users =  $user->pluck("id")->toArray()
            :    $users = [$user->id];

        return  Ban::whereIn("user_id", $users)->delete();
    }


    public function banIP(string|array|SupportCollection $ip, ?Carbon $expired_at = null): bool
    {
        if (is_array($ip)) {
            return array_map(
                fn ($usr) => $this->banIP($usr, $expired_at),
                $ip
            )[0];
        }

        try {
            Ban::updateOrCreate(
                ["ip" => $ip],
                ["expired_at" => $expired_at]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    public function unbanIP(string|array $ip): bool
    {
        $ips = is_array($ip) ? $ip : [$ip];

        return Ban::whereIn("ip", $ips)->delete();
    }
}
