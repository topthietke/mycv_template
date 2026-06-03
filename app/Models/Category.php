<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    protected $table = 'categories';
    protected $fillable = ['code', 'name'];
    public function candidateContents() {
        return $this->hasMany(CandidateContent::class, 'category_id', 'id');
    }
}
