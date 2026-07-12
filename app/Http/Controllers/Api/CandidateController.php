<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreCandidateRequest;
use App\Http\Requests\Candidate\UpdateCandidateRequest;
use App\Services\Candidate\CandidateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class CandidateController extends Controller {
    protected $can_service;

    public function __construct(CandidateService $can_service) {
        $this->can_service = $can_service;
    }
    public function store(StoreCandidateRequest $request): JsonResponse {
        try {
            $data = $request->validated();

            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->uploadAvatar($request->file('avatar'));
            }            
            $candidate = $this->can_service->create($data);
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký tài khoản ứng viên thành công!',
                'data'    => $candidate
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình xử lý.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function index(Request $request): JsonResponse {        
        try {
            $data = $this->can_service->index($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải danh sách ứng viên.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin chi tiết một ứng viên.
     */
    public function show($id): JsonResponse {
        try {
            $result = $this->can_service->edit($id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải chi tiết ứng viên.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(UpdateCandidateRequest $request, $id): JsonResponse {
        try {
            $data = $request->validated();
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->uploadAvatar($request->file('avatar'));
            } 
            $result = $this->can_service->update($data, $id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật thông tin.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa ứng viên.
     */
    public function destroy($id): JsonResponse {
        try {
            $result = $this->can_service->delete($id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa ứng viên.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // =================================================== Upload file =====================================================
    private function uploadAvatar(UploadedFile $file): string {
        // 1. Lấy tên file gốc và extension (jpg, png...)
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
        $extension = $file->getClientOriginalExtension();

        // 2. Slug lại tên file để tránh ký tự đặc biệt + thêm chuỗi ngẫu nhiên/thời gian để tránh trùng file
        $safeName = Str::slug($originalName) . '-' . time() . '.' . $extension;

        // 3. Định nghĩa thư mục đích trong public (public/img)
        $destinationPath = public_path('assets/img');        

        // 4. Di chuyển file từ thư mục tạm (/tmp) vào thư mục đích
        $file->move($destinationPath, $safeName);

        // 5. Trả về đường dẫn định dạng mong muốn
        return '/assets/img/' . $safeName; // Return a relative path for storage
    }
}