<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class student extends Model
{
    use HasFactory;
    public $table = 'student';


    protected $fillable = ["user_id","firstName","lastName","birthday"];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];
    public static function empty():array
    {
        return [
            'user_id' => 0,
            'firstName' => '',
            'lastName' => '',
            'birthday' => '',
        ];
    }
}
