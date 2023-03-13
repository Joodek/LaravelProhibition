<?php

namespace Joodek\Prohibition;

use Illuminate\Foundation\Auth\User as Authenticable;
use Joodek\Prohibition\Exceptions\NotAuthenticableException;
use Joodek\Prohibition\Facades\Prohibition;


trait Bannable
{
    /**
     * ban the user forever
     */
    public function ban(): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel($this);
    }

    /**
     * ban the user for the given years
     */
    public function banForYears(int $years = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addYears($years)
        );
    }

    /**
     * ban the user for the given months
     */
    public function banForMonths(int $months = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addMonths($months)
        );
    }

    /**
     * ban the user for the given weeks
     */
    public function banForWeeks(int $weeks = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addWeeks($weeks)
        );
    }

    /**
     * ban the user for the given days
     */
    public function banForDays(int $days = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addDays($days)
        );
    }

    /**
     * ban the user for the given hours
     */
    public function banForHours(int $hours = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addHours($hours)
        );
    }

    /**
     * ban the user for the given minutes
     */
    public function banForMinutes(int $minutes = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addMinutes($minutes)
        );
    }

    /**
     * ban the user for the given minutes
     */
    public function banForSeconds(int $seconds = 1): bool
    {
        $this->isAuthenticable();

        return Prohibition::banModel(
            $this,
            now()->addSeconds($seconds)
        );
    }

    /**
     * unban the user
     */
    public function unban()
    {
        $this->isAuthenticable();

        return Prohibition::unbanModel($this);
    }

    /**
     * check wether the user is banned or not
     */
    public function banned(): bool
    {
        return Prohibition::banned(
            user: $this
        );
    }


    private function isAuthenticable()
    {
        if (!$this instanceof Authenticable) {
            NotAuthenticableException::throw($this);
        }
    }
}
