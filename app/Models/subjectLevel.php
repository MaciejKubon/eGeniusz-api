<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class subjectLevel extends Model
{
    use HasFactory;
    public $table = 'subject_level';
    protected $fillable = ["id","level"];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function lesson(): hasMany
    {
        return $this->hasMany(lesson::class);
    }
}
