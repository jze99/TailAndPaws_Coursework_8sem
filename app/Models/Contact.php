<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo',
        'favicon',
        'phone',
        'email',
        'address',
        'work_hours',
        'telegram',
        'whatsapp',
        'vkontakte',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public static function getData()
    {
        return self::first() ?? self::create();
    }
}
