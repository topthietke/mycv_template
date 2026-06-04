<?php

namespace App\Models;

class CandidateContent extends BaseModel
{
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
