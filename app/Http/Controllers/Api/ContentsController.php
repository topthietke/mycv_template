<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contents\CategoriesContentsRequest;
use App\Services\Catetories\CatetoriesService;
use App\Services\Contents\ContentsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Str;

class ContentsController extends Controller
{
    protected $content_service;
    protected $cat_services;
    public function __construct(
        ContentsService $content_service,
        CatetoriesService $cat_services
    ) {
        $this->content_service = $content_service;
        $this->cat_services = $cat_services;
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

    public function create_multiple(Request $request): JsonResponse
    {
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

    public function update_multiple_data(Request $request): JsonResponse
    {
        return response()->json($this->content_service->update_multiple_data($request->all()), 201);
    }

    public function create_multiple_data(CategoriesContentsRequest $request): JsonResponse
    {
        try {
            $dem = 0;
            $params = $request->all();
            if (empty($params['code'])) {
                $params['code'] = Str::slug($params['categories_name']);
            }
            $data_categories = [
                "name"         => $params['categories_name'] ?? '',
                "candidate_id" => $params['candidate_id'] ?? '',
                "code"         => $params['code'] ?? '',
                "pages"        => $params['pages'] ?? '1',
                "created_by"   => Auth::user()->id ?? ($params['candidate_id'] ?? null),
                "created_at"   => Carbon::now()
            ];
            $categories = $this->cat_services->create($data_categories);
            if (!empty($model->id)) {
                $data_content = [
                    "candidate_id" => $params['candidate_id'] ?? '',
                    "category_id"  => $categories['id'],
                    "content"      => $params['content'] ?? '',
                    "created_by"   => Auth::user()->id ?? ($params['candidate_id'] ?? null),
                    "created_at"   => Carbon::now()
                ];
                $this->content_service->create($data_content);
                $dem += 1;
                
            }
            return response()->json([
                'code' => 200,
                'message' => "Thêm mới thành công"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình tạo nội dung.',
                'error' => $e->getMessage()
            ], 500);
        }




        return response()->json($this->content_service->create_multiple_data($request->all()), 201);
    }
}
