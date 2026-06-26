<?php

namespace App\Services\Candidate;

use App\Events\CandidateCreatedEvent;
use App\Events\SendMailEvent;
use App\Repository\CandidateRepository;
use App\Helpers\Helpers;
use App\Jobs\SendAccountInfoMailJob;
use App\Repository\AuthRepository;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CandidateService
{
    use Helpers;
    protected $candidate_repository;
    protected $auth_repository;

    public function __construct(
        CandidateRepository $candidate_repository,
        AuthRepository $auth_repository
    ) {
        $this->candidate_repository = $candidate_repository;
        $this->auth_repository      = $auth_repository;
    }

    public function index($params)
    {
        return $this->candidate_repository->index($params);
    }

    public function edit($id)
    {
        return $this->candidate_repository->edit($id);
    }


    public function create($data) {
        $params = $this->candidate_repository->create($data);
        $params['password'] = $password = Str::random(16);
        CandidateCreatedEvent::dispatch($params);        
        $c_user = $this->auth_repository->countByConditions($params);    
        if (!empty($c_user) || $c_user > 0) {
            $data_email = [
                'name'     => $params['fullname'],
                'email'    => $params['email'],
                'password' => $password,
                'url'      => config('app.url') . '/login',
            ];
            // $this->send_mail($data_email);
            SendAccountInfoMailJob::dispatch($data_email);
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
