<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    use HasFactory;
     public  $table = 'lesson';
     protected $fillable = ["id_subject", "id_subject_level", "id_teacher", "price"];
     protected $hidden = ["created_at", "updated_at"];
}
