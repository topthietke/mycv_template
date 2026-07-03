<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends BaseModel
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;   
    protected $table = 'categories';
    protected $fillable = [
        "id",  "code",  "name",  "candidate_id", "pages",  "created_by",  "updated_by",  "deleted_by",  "created_at",  "updated_at",  "deleted_at"
    ];
    public function contents() {
        return $this->hasMany(CandidateContent::class, 'category_id', 'id');
    }
}
