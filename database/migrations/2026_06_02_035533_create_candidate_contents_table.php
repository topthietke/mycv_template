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
            $table->bigInteger('candidate_id')->nullable(FALSE)->comment('ID của ứng viên');
            $table->bigInteger('category_id')->nullable(FALSE)->comment('ID của danh mục');
            $table->longText('content')->nullable(FALSE)->comment('Nội dung của CV theo ứng viên, danh mục');            
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
