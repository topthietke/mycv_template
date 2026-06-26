<?php

namespace App\Repository;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoriesRepository {
    private $categories;
    public function __construct(Category $categories) {
        $this->categories = $categories;
    }
    public function whereByConditions($params){
        return $this->categories->findByConditions($params);
    }
    public function index($params) {
        try {
            $model = $this->categories->getWithRelations(['contents']);
            if ($model->isNotEmpty()) {
                return [
                    'code' => 200,
                    'message' => 'Tải danh sách danh mục thành công',
                    'data' => $model
                ];
            } else {
                return [
                    'code' => 201,
                    'message' => 'Tải danh sách danh mục không thành công',
                    'data' => null
                ];
            }
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }        
    }

    public function edit($id) {
        try {
            $model = $this->categories->findById($id);
            if (!empty($model)) {
                $data = [
                    'code' => 200,
                    'message' => 'Tải chi tiết danh mục thành công',
                    'data' => $model
                ];
            } else {
                $data = [
                    'code' => 201,
                    'message' => 'Tải chi tiết danh mục không thành công',
                    'data' => null
                ];
            }
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
        return $data;
    }

    public function create($data) {
        return $this->categories->createRecord($data);
    }

    public function create_multiple($data) {
        return $this->categories->insert($data);
    }

    public function update($params, $id) {        
        $record = $this->categories->findById($id);        
        if (empty($record)) {
            return [
                'code' => 404,
                'message' => 'Không tìm thấy danh mục để cập nhật',
            ];
        }

        $updateData = [
            'name'       => $params['name'] ?? $record->name,
            'code'       => $params['code'] ?? $record->code,
            'updated_by' => Auth::user()->id ?? null,
            'updated_at' => now(),
        ];

        if ($this->categories->updateById($id, $updateData)) {
            return [
                'code' => 200,
                'message' => 'Cập nhật danh mục thành công',
                'data' => $this->categories->findById($id)
            ];
        } else {
            return [
                'code' => 500,
                'message' => 'Cập nhật danh mục không thành công',
            ];
        }
    }

    public function delete($id) {
        try {
            $record = $this->categories->find($id);
            if (!$record) {
                return [
                    'code' => 404,
                    'message' => 'Không tìm thấy danh mục để xóa',
                    'data' => null
                ];
            }

            $deleted = $record->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id ?? null
            ]);

            if ($deleted) {
                return [
                    'code' => 200,
                    'message' => 'Xóa bỏ danh mục thành công',
                    'data' => true
                ];
            }
            return [
                'code' => 201,
                'message' => 'Xóa bỏ danh mục không thành công',
                'data' => null
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function deleteByCollumn(string $column, mixed $value) {
        try {
            return $this->categories->deleteByCollumn($column, $value);
        } catch (\Throwable $e) {
            return [
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }
}
