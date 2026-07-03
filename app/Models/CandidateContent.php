<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class CandidateContent extends BaseModel
{
     use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    protected $table = 'candidate_contents';
    protected $fillable = [
        "id",
        "candidate_id",
        "category_id",
        "content",
        "created_by",
        "updated_by",
        "deleted_by",
        "created_at",
        "updated_at",
        "deleted_at"  ,
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
