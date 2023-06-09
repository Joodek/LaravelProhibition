<?php

namespace Cata\Prohibition;

use Cata\Prohibition\Facades\Prohibition;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishes();

        $this->registerRequestMacros();
    }


    private function registerPublishes()
    {
        $this->publishes(
            [
                dirname(__DIR__) . "/config/prohibition.php" => config_path("prohibition.php"),
                dirname(__DIR__) . "/database/migrations/create_ban_table.php" => database_path("migrations/create_ban_table.php"),
            ],
            "config"
        );

        $this->publishes(
            [
                dirname(__DIR__) . "/tests/ProhibitionTest.php" => base_path("/tests/Feature/ProhibitionTest.php")
            ],
            "prohibition-tests"
        );
    }


    private function registerRequestMacros()
    {
        Request::macro("ban", fn () =>  Prohibition::banIP(request()->ip()));
        Request::macro("unban", fn () =>  Prohibition::unbanIP(request()->ip()));
        Request::macro("banned", fn () =>  Prohibition::banned(ip: request()->ip()));

        Request::macro(
            "banForSeconds",
            fn (int $seconds = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addSeconds($seconds)
            )
        );

        Request::macro(
            "banForMinutes",
            fn (int $minutes = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addMinutes($minutes)
            )
        );

        Request::macro(
            "banForHours",
            fn (int $hours = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addHours($hours)
            )
        );

        Request::macro(
            "banForDays",
            fn (int $days = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addDays($days)
            )
        );

        Request::macro(
            "banForWeeks",
            fn (int $weeks = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addWeeks($weeks)
            )
        );
        Request::macro(
            "banForMonths",
            fn (int $months = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addMonths($months)
            )
        );
        Request::macro(
            "banForYears",
            fn (int $years = 1) =>  Prohibition::banIP(
                ip: request()->ip(),
                expired_at: now()->addYears($years)
            )
        );
    }
}
