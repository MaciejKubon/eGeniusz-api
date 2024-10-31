<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    public $table = 'subject';
    protected $fillable = ["id","name"];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
