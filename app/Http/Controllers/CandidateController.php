<?php

namespace App\Http\Controllers;

use App\Http\Requests\Candidate\StoreCandidateRequest;
use App\Http\Requests\Candidate\UpdateCandidateRequest;
use App\Services\Candidate\CandidateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CandidateController extends Controller {
    protected $can_service;

    public function __construct(CandidateService $can_service) {
        $this->can_service = $can_service;
    }
    public function store(StoreCandidateRequest $request): JsonResponse {        
        try {
            $candidate = $this->can_service->create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký tài khoản ứng viên thành công!',
                'data' => $candidate
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình xử lý.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Lấy danh sách ứng viên.
     */
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

    /**
     * Cập nhật thông tin ứng viên.
     */
    public function update(UpdateCandidateRequest $request, $id): JsonResponse {
        try {
            $result = $this->can_service->update($request->all(), $id);
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
}