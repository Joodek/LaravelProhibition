<?php

namespace Joodek\Prohibition\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Ban extends Model
{
    public $table = "laravel_ban";


    protected $fillable  = [
        "user_id",
        "ip",
        "expired_at"
    ];


    public function user()
    {
        return $this->belongsTo(
            config("prohibition.model", User::class),
            "user_id"
        );
    }
}
