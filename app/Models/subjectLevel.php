<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjectLevel extends Model
{
    use HasFactory;
    public $table = 'subject_level';
    protected $fillable = ["id","level"];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
