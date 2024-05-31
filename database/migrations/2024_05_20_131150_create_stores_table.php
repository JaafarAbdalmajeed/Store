<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {

            // id BIGINT UNSIGNED AUTO INCREMENT PRIMARY
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // unsignedBigInteger('id')->primary()
            // bigIncrement('id')

            $table->id();
            $table->string('name'); // 255 ,  VARCHAR(64000) MAXIMUM SIZE
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamps(); // 2 columns: created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
