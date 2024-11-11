<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function lesson(): hasMany
    {
        return $this->hasMany(lesson::class);
    }
    public function terms(): hasMany
    {
        return $this->hasMany(terms::class);
    }
}
