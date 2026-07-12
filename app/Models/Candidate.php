<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Candidate extends BaseModel
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;   
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
