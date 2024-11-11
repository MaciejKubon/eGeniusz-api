<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class terms extends Model
{
    use HasFactory;
    public $table = 'terms';
    protected $fillable = ["id", "teacher_id", "start_date","end_date"];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
