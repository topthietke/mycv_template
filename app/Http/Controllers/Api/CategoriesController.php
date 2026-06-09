<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Catetories\CatetoriesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller {
    protected $cat_service;

    public function __construct(CatetoriesService $cat_service)
    {
        $this->cat_service = $cat_service;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->cat_service->index($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải danh sách danh mục.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse {
        try {
            $category = $this->cat_service->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Tạo danh mục thành công!',
                'data' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình tạo danh mục.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create_multiple(Request $request): JsonResponse
    {
        try {
            $categories = $this->cat_service->create_multiple($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Tạo nhiều danh mục thành công!',
                'data' => $categories
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình tạo nhiều danh mục.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show($id): JsonResponse
    {
        try {
            $result = $this->cat_service->edit($id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải chi tiết danh mục.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $result = $this->cat_service->update($request->all(), $id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật danh mục.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->cat_service->delete($id);
            return response()->json($result, $result['code'] ?? 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
