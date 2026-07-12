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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(false); // 'objective', 'skill', 'experience', 'education'
            $table->string('name')->nullable(false);
            $table->bigInteger('candidate_id')->nullable()->default(null);
            $table->string('pages', 100)->nullable()->default(null)->comment('Chỉ định categories năm ở page nào');
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
        Schema::dropIfExists('categories');
    }
};
