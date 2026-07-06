<?php

namespace App\Repository;
use App\Models\CandidateContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ContentsRepository {
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    private $contents;
    public function __construct(CandidateContent $contents)
    {
        $this->contents = $contents;
    }

    public function index($params) {
        try {
            $model = $this->contents->findByConditions($params);
            if ($model->isNotEmpty()) {
                $data = [
                    'code' => 200,
                    'message' => 'Tải danh sách nội dung ứng viên thành công',
                    'personal' => $model
                ];
            } else {
                $data = [
                    'code' => 201,
                    'message' => 'Tải danh sách nội dung ứng viên không thành công',
                    'personal' => null
                ];
            }
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'message' => $e->getMessage(),
                'personal' => null
            ];
        }
        return $data;
    }
    public function edit($id) {
        try {
            $model = $this->contents->findById($id);
            if (!empty($model)) {
                $data = [
                    'code' => 200,
                    'message' => 'Tải chi tiết nội dung thành công',
                    'personal' => $model
                ];
            } else {
                $data = [
                    'code' => 201,
                    'message' => 'Tải chi tiết nội dung không thành công',
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
        return $this->contents->createRecord($data);
    }
    public function create_multiple($data) {
        return $this->contents->insert($data);
    }
    public function update($params, $id) {
        $record = $this->contents->findById($id);
        if (empty($record)) {
            return [
                'code' => 404,
                'message' => 'Không tìm thấy nội dung để cập nhật',
            ];
        }

        $updateData = [
            'candidate_id' => $params['candidate_id'] ?? $record->candidate_id,
            'category_id'  => $params['category_id'] ?? $record->category_id,
            'content'      => $params['content'] ?? $record->content,
            'updated_by'   => Auth::user()->id ?? null,
        ];

        if ($this->contents->updateById($id, $updateData)) {
            return [
                'code' => 200,
                'message' => 'Cập nhật nội dung thành công',
                'data' => $this->contents->findById($id)
            ];
        } else {
            return [
                'code' => 500,
                'message' => 'Cập nhật nội dung không thành công',
            ];
        }
    }
    public function delete($id) {
        try {
            $record = $this->contents->find($id);
            if (!$record) {
                return [
                    'code' => 404,
                    'message' => 'Không tìm thấy nội dung để xóa',
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
                    'message' => 'Xóa bỏ nội dung thành công',
                    'personal' => true
                ];
            }
            return [
                'code' => 201,
                'message' => 'Xóa bỏ nội dung không thành công',
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
            return $this->contents->deleteByCollumn($column, $value);
        } catch (\Throwable $e) {
            return [
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }
    public function whereByCollumn(array $params) {
        $model = $this->contents->findByConditions($params);
        return $model;
    }
}
