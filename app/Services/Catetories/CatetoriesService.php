<?php

namespace App\Services\Catetories;

use App\Repository\CategoriesRepository;
use App\Http\Traits\General;
use Illuminate\Support\Facades\Auth;
use Str;
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
        try {
            return $this->categoriesRepo->index($params);
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }
    }

    public function edit(string $id)
    {        
        return $this->categoriesRepo->edit($id);
    }

    public function create($data)
    {
        if (empty($data['code'])) {
            $data['code'] = Str::slug($data['name']);
        }
        return $this->categoriesRepo->create($data);
    }

    public function create_multiple($params)
    {
        $data = [];
        foreach ($params['name'] as $item) {
            $data[] = [
                'name' => $item,
                'code' => Str::slug($item),
                'candidate_id' => $params['candidate_id'],
                'created_by' => Auth::user()->id ?? null,
                'created_at' => now(),
            ];
        }
        $categories = $this->categoriesRepo->create_multiple($data);
        if ($categories) {
            $params = [
                'candidate_id' => $params['candidate_id']
            ];
            $data = $this->categoriesRepo->whereByConditions($params);
            return [
                "code" => 200,
                "message" => "Tạo nhiều danh mục thành công",
                "data" => $data
            ];
        } else {
            return [
                "code" => 403,
                "message" => "Tạo nhiều danh mục không thành công",
                "data" => $data
            ];
        }
    }

    public function update($data, $id)
    {
        if (empty($data['code'])) {
            $data['code'] = Str::slug($data['name']);
        }
        $data['updated_by'] = Auth::user()->id ?? null;
        $data['updated_at'] = now();
        return $this->categoriesRepo->update($data, $id);
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
