<?php

namespace Joodek\Prohibition;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Joodek\Prohibition\Facades\Prohibition;
use Joodek\Prohibition\Http\Middleware\BlockBannedUsersMiddleware;

class ProhibitionServiceProvider extends ServiceProvider
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

        $this->registerMiddleware();

        $this->registerRequestMacros();
    }


    private function registerPublishes()
    {
        $this->publishes(
            [
                dirname(__DIR__) . "/config/prohibition.php" => config_path("prohibition.php"),
                dirname(__DIR__) . "/database/migrations/create_ban_table.php" => database_path("migrations/create_ban_table.php"),
            ]
        );
    }

    private function registerMiddleware()
    {
        app("router")->middleware("prohibition", BlockBannedUsersMiddleware::class);
    }

    private function registerRequestMacros()
    {
        Request::macro("banned", fn () =>  Prohibition::IPBanned(request()->ip()));
        Request::macro("ban", fn () =>  Prohibition::banIp(request()->ip()));
        Request::macro("banForMinutes", fn () =>  Prohibition::banIpForMinutes(request()->ip()));
        Request::macro("banForHours", fn () =>  Prohibition::banIpForHours(request()->ip()));
        Request::macro("banForDays", fn () =>  Prohibition::banIpForDays(request()->ip()));
        Request::macro("banForWeeks", fn () =>  Prohibition::banIpForWeeks(request()->ip()));
        Request::macro("banForMonths", fn () =>  Prohibition::banIpForMonths(request()->ip()));
        Request::macro("banForYears", fn () =>  Prohibition::banIpForYears(request()->ip()));
        Request::macro("unban", fn () =>  Prohibition::unban(request()->ip()));
    }
}
