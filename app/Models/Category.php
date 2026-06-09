<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    protected $table = 'categories';
    protected $fillable = [
        "id",  "code",  "name",  "candidate_id",  "created_by",  "updated_by",  "deleted_by",  "created_at",  "updated_at",  "deleted_at"
    ];
    public function candidateContents() {
        return $this->hasMany(CandidateContent::class, 'category_id', 'id');
    }
}
