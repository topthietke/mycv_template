<?php

namespace App\Services\Candidate;

use App\Repository\CandidateRepository;

class CandidateService
{
    protected CandidateRepository $candidate_repository;

    public function __construct(CandidateRepository $candidate_repository)
    {
        $this->candidate_repository = $candidate_repository;
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
        return $this->candidate_repository->create($data);
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
