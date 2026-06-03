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
            $table->string('fullname');
            $table->string('position');
            $table->date('birthday');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('identity_card');
            $table->date('identity_date');
            $table->string('identity_place');
            $table->string('home_town');
            $table->string('current_address');
            $table->decimal('expected_salary', 15, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('git_url')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
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
