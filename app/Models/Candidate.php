<?php

namespace App\Models;

class Candidate extends BaseModel
{
    protected $table = 'candidates';
    protected $fillable = [
        'fullname', 'position', 'birthday', 'gender', 'email', 'phone',
        'identity_card', 'identity_date', 'identity_place', 'home_town',
        'current_address', 'expected_salary', 'avatar', 'facebook_url', 'git_url', 'website_url'
    ];

    public function categories() {
        return $this->hasMany(CandidateContent::class, 'candidate_id', 'id');
    }
}
