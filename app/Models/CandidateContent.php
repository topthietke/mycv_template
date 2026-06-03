<?php

namespace App\Models;

class CandidateContent extends BaseModel
{
    protected $table = 'candidate_contents';
    protected $fillable = ['candidate_id', 'category_id', 'content'];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
