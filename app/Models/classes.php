<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class classes extends Model
{
    use HasFactory;
    public $table = 'classes';

    protected $fillable = [
        "id",
        "terms_id",
        "student_id",
        "lesson_id",
        "confirmed"
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(student::class, 'student_id','user_id');
    }
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(lesson::class);
    }
    public function terms(): BelongsTo
    {
        return $this->belongsTo(terms::class);
    }
}
