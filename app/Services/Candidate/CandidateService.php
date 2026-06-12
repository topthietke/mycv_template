<?php

namespace App\Services\Candidate;

use App\Repository\CandidateRepository;
use App\Helpers\Helpers;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CandidateService
{    
    use Helpers;
    protected $candidate_repository;
    protected $user_factory;

    public function __construct(
        CandidateRepository $candidate_repository,
        UserFactory $user_factory
    )
    {
        $this->candidate_repository = $candidate_repository;
        $this->user_factory         = $user_factory;
    }

    public function index($params)
    {
        return $this->candidate_repository->index($params);
    }

    public function edit($id)
    {
        return $this->candidate_repository->edit($id);
    }

    public function create($data)
    {
        $params = $this->candidate_repository->create($data);        
        $password = Str::random(16);        
        $data_users = [
            'name'     => $params['fullname'],
            'email'    => $params['email'],
            'password' => Hash::make($password),            
        ];
        $users = $this->user_factory->create($data_users);
        if(!empty($users)) {
            $data_email = [
                'name'     => $params['fullname'],
                'email'    => $params['email'],
                'password' => $password,
                'url'      => config('app.url') . '/login',
            ];
            $this->send_mail($data_email);
        }
        return $params;
    }

    public function createMultiple($data)
    {
        return $this->candidate_repository->create_multiple($data);
    }

    public function update($params, $id)
    {
        return $this->candidate_repository->update($params, $id);
    }

    public function delete($id)
    {
        return $this->candidate_repository->delete($id);
    }

    public function deleteByColumn(string $column, $value)
    {
        return $this->candidate_repository->deleteByCollumn($column, $value);
    }
}
