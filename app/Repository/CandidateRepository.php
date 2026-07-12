<?php

namespace App\Repository;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class CandidateRepository {
    private $candidate;
    public function __construct(Candidate $candidate) {
        $this->candidate = $candidate;
    }

    public function index($params){
        try {
            $model = $this->candidate->findByConditions($params);
            if ($model->isNotEmpty()) {
                $data = [
                    'code' => 200,
                    'message' => 'Tải danh sách ứng viên thành công',
                    'data' => $model

                ];
            } else {
                $data = [
                    'code' => 201,
                    'message' => 'Tải danh sách ứng viên không thành công',                    
                ];
            }
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'message' => $e->getMessage(),                
            ];
        }
        return $data;
    }

    public function edit($id) {
        try {
            $model = $this->candidate->findById($id);
            if (!empty($model)) {
                $data = [
                    'code' => 200,
                    'message' => 'Tải chi tiết ứng viên thành công',
                    'data' => $model

                ];
            } else {
                $data = [
                    'code' => 201,
                    'message' => 'Tải chi tiết ứng viên không thành công',                    
                ];
            }
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'message' => $e->getMessage(),                
            ];
        }
        return $data;
    }

    public function create($data) {
        return $this->candidate->createRecord($data);
    }

    public function create_multiple($data){
        return $this->candidate->insert($data);
    }

    public function update($params, $id) {
        $record = $this->candidate->findById($id);        
        if(empty($record)) {
            return [
                'code' => 404,
                'message' => 'Không tìm thấy thông tin ứng viên để cập nhật',
            ];
        }

        $updateData = [
            'fullname'        => $params['fullname'] ?? $record->fullname,
            'position'        => $params['position'] ?? $record->position,
            'birthday'        => $params['birthday'] ?? $record->birthday,
            'gender'          => $params['gender'] ?? $record->gender,
            'email'           => $params['email'] ?? $record->email,
            'phone'           => $params['phone'] ?? $record->phone,
            'identity_card'   => $params['identity_card'] ?? $record->identity_card,
            'identity_date'   => $params['identity_date'] ?? $record->identity_date,
            'identity_place'  => $params['identity_place'] ?? $record->identity_place,
            'home_town'       => $params['home_town'] ?? $record->home_town,
            'current_address' => $params['current_address'] ?? $record->current_address,
            'expected_salary' => $params['expected_salary'] ?? $record->expected_salary,
            'facebook_url'    => $params['facebook_url'] ?? $record->facebook_url,
            'git_url'         => $params['git_url'] ?? $record->git_url,
            'website_url'     => $params['website_url'] ?? $record->website_url,
            'avatar'          => $params['avatar'] ?? $record->avatar,
            'updated_by'      => Auth::id(),
        ];
                
        if (isset($params['avatar'])) {
            $updateData['avatar'] = $params['avatar'];
        }
        if($this->candidate->updateById($id, $updateData)) {
            return [
                'code' => 200,
                'message' => 'Cập nhật thông tin ứng viên thành công',
                'data' => $this->candidate->findById($id) // Fetch the updated model
            ];
        } else {
            return [
                'code' => 500,
                'message' => 'Cập nhật thông tin ứng viên không thành công',
            ];
        }
    }

    public function delete($id) {
        try {
            $record = $this->candidate->find($id);
            if (!$record) {
                return [
                    'code' => 404,
                    'message' => 'Không tìm thấy thông tin ứng viên để xóa',
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
                    'message' => 'Xóa bỏ thông tin ứng viên thành công',
                    'data' => true
                ];
            }
            return [
                'code' => 201,
                'message' => 'Xóa bỏ thông tin ứng viên không thành công',
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

    public function deleteByCollumn(string $column, mixed $value ) {
        try {
            return $this->candidate->deleteByCollumn($column, $value);
        } catch (\Throwable $e) {
             return [
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

}