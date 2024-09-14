<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userDescription extends Model
{
    use HasFactory;
    public $table = 'user_description';
    protected $fillable = ["description"];
    protected $hidden = ["created_at", "updated_at"];
}
