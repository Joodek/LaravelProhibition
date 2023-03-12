<?php

namespace Joodek\Prohibition;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Joodek\Prohibition\Models\Ban;

class LaravelProhibition
{
    use BannableIP;


    public function authorize(Request $request): void
    {
        if (!config("prohibition.restrict")) return;

        abort_if(
            $this->banned($request->user(), $request->ip()),
            config("prohibition.error.code", 403),
            config("prohibition.error.message", "Unauthorized")
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
}
