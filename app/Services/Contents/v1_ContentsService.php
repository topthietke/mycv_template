<?php

namespace App\Services\Contents;

use App\Models\CandidateContent;
use App\Repository\ContentsRepository;
use Illuminate\Support\Facades\Auth;

class ContentsService {
    protected $content_repository;

    public function __construct(ContentsRepository $content_repository)
    {
        $this->content_repository = $content_repository;
    }

    public function index($params)
    {
        return $this->content_repository->index($params);
    }

    public function edit($id)
    {
        return $this->content_repository->edit($id);
    }

    public function create($data) {        
        return $this->content_repository->create($data);
    }

    public function create_multiple($params) {
        $data = [];
        foreach ($params as $value) {
            $value['created_by'] = Auth::user()->id ?? null;
            $value['created_at'] = now();            
            $data [] = $value;
        }
        return $this->content_repository->create_multiple($data);
    }

    public function update($params, $id)
    {
        return $this->content_repository->update($params, $id);
    }

    public function delete($id)
    {
        return $this->content_repository->delete($id);
    }

    public function deleteByCollumn(string $column, mixed $value)
    {
        return $this->content_repository->deleteByCollumn($column, $value);
    }

    public function update_multiple_data(array $data)
    {        
        $dem = 0;
        foreach ($data as $value) {            
            $params = [
                "content"    => $value['content'] ?? null,
                "pages"      => $value['pages'] ?? null,
                "updated_by" => Auth::user()->id ?? null,
                "updated_at" => now()
            ];          
            $update = CandidateContent::where('category_id', $value['category_id'])->update($params);            
            if($update > 0) $dem += 1;
        }
        if($dem > 0) {
            return [
                'code' => 200,
                'message' => 'Cập nhật nội dung thành công',            
            ];
        } else  {
            return [
                'code' => 500,
                'message' => 'Cập nhật nội dung không thành công',                        
            ];
        }

    }
}
