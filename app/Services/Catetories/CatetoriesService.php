<?php

namespace App\Services\Catetories;

use App\Repository\CategoriesRepository;

// use App\Repositories\categoriesRepository;


class CatetoriesService
{
    protected $categoriesRepo;

    public function __construct(CategoriesRepository $categoriesRepo)
    {
        $this->categoriesRepo = $categoriesRepo;
    }

    public function index($params)
    {
        return $this->categoriesRepo->index($params);
    }

    public function edit($id)
    {
        return $this->categoriesRepo->edit($id);
    }

    public function create($data)
    {
        return $this->categoriesRepo->create($data);
    }

    public function create_multiple($data)
    {
        return $this->categoriesRepo->create_multiple($data);
    }

    public function update($params, $id)
    {
        return $this->categoriesRepo->update($params, $id);
    }

    public function delete($id)
    {
        return $this->categoriesRepo->delete($id);
    }

    public function deleteByCollumn(string $column, mixed $value)
    {
        return $this->categoriesRepo->deleteByCollumn($column, $value);
    }
}
