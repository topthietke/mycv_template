<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidate_contents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('candidate_id')->nullable()->default(null);
            $table->bigInteger('category_id')->nullable()->default(null);
            $table->longText('content'); // Lưu nội dung chi tiết dạng chuỗi hoặc JSON tùy thuộc nhu cầu mở rộng
            $table->bigInteger('created_by')->nullable()->default(null);
            $table->bigInteger('updated_by')->nullable()->default(null);
            $table->bigInteger('deleted_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_contents');
    }
};
