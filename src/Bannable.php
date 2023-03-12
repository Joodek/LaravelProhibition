<?php

namespace Joodek\Prohibition;

use Illuminate\Foundation\Auth\User as Authenticable;
use Joodek\Prohibition\Exceptions\NotAuthenticableException;
use Joodek\Prohibition\Models\Ban;

trait Bannable
{
    /**
     * ban the user forever
     */
    public function ban(): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the user for the given years
     */
    public function banForYears(int $years = 1): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ],
                [
                    "expired_at" => now()->addYears($years)
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the user for the given months
     */
    public function banForMonths(int $months = 1): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ],
                [
                    "expired_at" => now()->addMonths($months)
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the user for the given weeks
     */
    public function banForWeeks(int $weeks = 1): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ],
                [
                    "expired_at" => now()->addWeeks($weeks)
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the user for the given days
     */
    public function banForDays(int $days = 1): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ],
                [
                    "expired_at" => now()->addDays($days)
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the user for the given hours
     */
    public function banForHours(int $hours = 1): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ],
                [
                    "expired_at" => now()->addHours($hours)
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the user for the given minutes
     */
    public function banForMinutes(int $minutes = 1): bool
    {
        $this->isAuthenticable();

        try {
            Ban::updateOrCreate(
                [
                    "user_id" => $this->id
                ],
                [
                    "expired_at" => now()->addMinutes($minutes)
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     * unban the user
     */
    public function unban()
    {
        $this->isAuthenticable();

        return Ban::whereUserId($this->id)->delete();
    }

    /**
     * check wether the user is banned or not
     */
    public function banned(): bool
    {
        $banned =  Ban::whereUserId($this->id)
            ->first();

        if (is_null($banned)) return false;

        if (!is_null($ex = $banned->expired_at) && $ex <= now()) {
            $banned->delete();
            return false;
        }

        return true;
    }


    private function isAuthenticable()
    {
        if (!$this instanceof Authenticable) {
            NotAuthenticableException::throw($this);
        }
    }
}
