<?php

namespace App\Services\Contents;

use App\Repository\ContentsRepository;
use Illuminate\Support\Facades\Auth;

class ContentsService {
    protected $content_repository;

    public function __construct(ContentsRepository $content_repository)
    {
        $this->content_repository = $content_repository;
    }

    public function index($params)
    {
        return $this->content_repository->index($params);
    }

    public function edit($id)
    {
        return $this->content_repository->edit($id);
    }

    public function create($data) {        
        return $this->content_repository->create($data);
    }

    public function create_multiple($params) {
        $data = [];
        foreach ($params as $value) {
            $value['created_by'] = Auth::user()->id ?? null;
            $value['created_at'] = now();            
            $data [] = $value;
        }
        return $this->content_repository->create_multiple($data);
    }

    public function update($params, $id)
    {
        return $this->content_repository->update($params, $id);
    }

    public function delete($id)
    {
        return $this->content_repository->delete($id);
    }

    public function deleteByCollumn(string $column, mixed $value)
    {
        return $this->content_repository->deleteByCollumn($column, $value);
    }

    public function update_multiple_data(array $data)
    {
        foreach ($data as $value) {
            # code...
        }
    }
}
