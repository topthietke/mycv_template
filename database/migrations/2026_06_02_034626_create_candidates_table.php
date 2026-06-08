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
       Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable(FALSE)->comment('Họ và tên');
            $table->string('position')->nullable(FALSE)->comment('Vị trí ứng tuyển');
            $table->date('birthday')->nullable(FALSE)->comment('Ngày sinh');
            $table->string('gender')->nullable(FALSE)->comment('Giới tính');
            $table->string('email')->unique()->nullable(FALSE)->comment('Email');
            $table->string('phone')->nullable(FALSE)->comment('Số điện thoại');
            $table->string('identity_card')->nullable()->default(NULL)->comment('CMND/CCCD');
            $table->date('identity_date')->nullable()->default(NULL)->comment('Ngày cấp');
            $table->string('identity_place')->nullable()->default(NULL)->comment('Nơi cấp');
            $table->string('home_town')->nullable()->default(NULL)->comment('Quê quán');
            $table->string('current_address')->nullable()->default(NULL)->comment('Địa chỉ hiện tại');
            $table->decimal('expected_salary', 15, 2)->nullable()->default(NULL)->comment('Mức lương kỳ vọng');
            $table->string('avatar')->nullable()->default(NULL)->comment('Ảnh đại diện');
            $table->string('facebook_url')->nullable()->default(NULL)->comment('URL Facebook');
            $table->string('git_url')->nullable()->default(NULL)->comment('URL GitHub');
            $table->string('website_url')->nullable()->default(NULL)->comment('URL Website');
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
        Schema::dropIfExists('candidates');
    }
};
