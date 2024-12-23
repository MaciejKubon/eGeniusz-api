<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class student extends Model
{
    use HasFactory;
    public $table = 'student';


    protected $fillable = ["user_id","firstName","lastName","birthday","imgPath"];

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
            'imgPath'=>'',
        ];
    }

    public function classes(): HasMany
    {
        return $this->hasMany(classes::class);
    }
}
