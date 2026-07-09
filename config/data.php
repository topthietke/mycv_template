<?php 
    return [
        "api_url" => env('API_URL'),        
        "activities_title"  => "Hoạt động",
        "company_name"      => "Tên công ty",
        "description"       => "Mô tả",
        "career_title"      => "Mục tiêu nghề nghiệp",
        "career_note"       => "Gợi ý: 3-5 câu, nêu kinh nghiệm, mục tiêu ngắn/dài hạn.",
        "education_tilte"   => "Quá trình đào tạo",
        "school_name"       => "Tên trường",
        "major_name"        => "Chuyên ngành",
        "edu_type_title"    => "Loại tốt nghiệp",
        "education_time"    => "Thời gian",
        "education_score"   => "Điểm",
        "education_type"    => [
            "0" => "Trung bình",
            "1" => "Khá",
            "2" => "Giỏi",
            "3" => "Xuất sắc",
        ],
        "skills_title"      => "Công nghệ",
        "skills_level"      => "Mức độ",
        "skills_data"       => [
            "0"             => "Đang tìm hiểu",
            "1"             => "Thành thạo",
            "2"             => "Cơ bản"
        ],
        "languages_head"    => "Ngoại ngữ",
        "languages_title"   => "Ngôn ngữ",
        "languages_level"   => "Mức độ",
        "languages_data"    => [
            "0" => "Tiếng Việt",
            "1" => "Tiếng Anh",
            "2" => "Tiếng Trung",            
        ],
        "cv_type"=> [
            "0" => "career_objective",
            "1" => "educations",
            "2" => "skills",
            "3" => "activities",
            "4" => "languages",
            "5" => "experiences"
        ],
        "msgErrors"        => [
            "name"         => [
                "required" => "Vui lòng nhập họ và tên."
            ],
            "jobs_title"   => [
                "required" => "Vui lòng nhập vị trí ứng tuyển."
            ],
            "day_of_birth" => [
                "required" => "Vui lòng nhập ngày sinh."
            ],
            "email"        => [
                "required" => "Vui lòng nhập email.",
                "email"    => "Vui lòng nhập email hợp lệ."
            ],
            "phone"        => [
                "required" => "Vui lòng nhập số điện thoại.",
                "phone"    => "Vui lòng nhập số điện thoại hợp lệ."
            ]
        ],
        "gender"  => [            
            "0"   => "Nữ",
            "1"   => "Nam",
            "2"   => "Khác"
        ],
        "page" => [
            "1"  => 1,
            "2"  => 2,
            "3"  => 3,
            "4"  => 4,
            "5"  => 5,
            "6"  => 6,
            "7"  => 7,
            "8"  => 8,
            "9"  => 9,
            "10" => 10
        ],
        "index" => [
            "title"             => "Thông tin cá nhân",
            "home_title"        => "Trang chủ",
            "career_title"      => "Mục tiêu nghề nghiệp",
            "educations_title"  => "Quá trình đào tạo",
            "skills_title"      => "Công nghệ",
            "activities_title"  => "Hoạt động",
            "languages_title"   => "Ngoại ngữ",
            "experiences_title" => "Kinh nghiệm làm việc",                        
        ],
        "edit" => [
            "title"         => "Chỉnh sửa thông tin", 
            "content_title" => "Quản lý danh mục và nội dung"
        ],
        "login" => [
            "title" => "Đăng nhập"
        ]
    ];
