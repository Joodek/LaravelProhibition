<?php

namespace Joodek\Prohibition\Exceptions;

use Exception;


class NotAuthenticableException extends Exception
{
    public static function throw($model)
    {
        throw new self(
            sprintf(
                "class %s is not authenticable , make sure your model extends %s class",
                $model::class,
                Illuminate\Foundation\Auth\User::class
            )
        );
    }
}
