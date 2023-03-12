<?php

namespace Joodek\Prohibition;

use Joodek\Prohibition\Models\Ban;

trait BannableIP
{
    /**
     * check wether the ip adress is banned or not
     */
    public function IPBanned(string $ip)
    {
        return Ban::whereIp($ip)
            ->exists();
    }

    /**
     * ban the ip forever
     */
    public function banIp(string $ip): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
                ]
            );

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * ban the ip for the given years
     */
    public function banIpForYears(string $ip, int $years = 1): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
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
     * ban the ip for the given months
     */
    public function banIpForMonths(string $ip, int $months = 1): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
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
     * ban the ip for the given weeks
     */
    public function banIpForWeeks(string $ip, int $weeks = 1): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
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
     * ban the ip for the given days
     */
    public function banIpForDays(string $ip, int $days = 1): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
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
     * ban the ip for the given hours
     */
    public function banIpForHours(string $ip, int $hours = 1): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
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
     * ban the ip for the given minutes
     */
    public function banIpForMinutes(string $ip, int $minutes = 1): bool
    {
        try {
            Ban::updateOrCreate(
                [
                    "ip" => $ip
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
     * unban the ip address
     */
    public function unban(string $ip)
    {
        return Ban::whereIp($ip)->delete();
    }
}
