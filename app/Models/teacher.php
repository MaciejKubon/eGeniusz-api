<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    use HasFactory;
    public $table = 'teacher';


    protected $fillable = ["user_id","firstName","lastName","birthday","description"];

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
            'description' => '',
        ];
    }
}
