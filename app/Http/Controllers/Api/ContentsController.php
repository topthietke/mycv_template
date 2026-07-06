<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contents\ContentsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContentsController extends Controller
{
    protected $content_service;

    public function __construct(ContentsService $content_service)
    {
        $this->content_service = $content_service;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->content_service->index($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải danh sách nội dung ứng viên.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $content = $this->content_service->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Tạo nội dung ứng viên thành công!',
                'data' => $content
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình tạo nội dung.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $result = $this->content_service->edit($id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải chi tiết nội dung.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            dd($request->all());
            $result = $this->content_service->update($request->all(), $id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật nội dung.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->content_service->delete($id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa nội dung.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create_multiple(Request $request): JsonResponse {
        try {
            $contents = $this->content_service->create_multiple($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Tạo nhiều nội dung thành công!',
                'data' => $contents
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình tạo nhiều nội dung.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_multiple_data(Request $request): JsonResponse {        
        return response()->json($this->content_service->update_multiple_data($request->all()), 201);
    }

}
