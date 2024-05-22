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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('chapterId');
            $table->unsignedBigInteger('categoryId');
            $table->string('name');
            $table->integer('price');
            $table->boolean('state');
            $table->boolean('type');
            $table->text('description');
            $table->text('gallery');
            $table->string('address');
            $table->integer('connectMethod');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('chapterId')->references('id')->on('chapters')->onDelete('cascade');
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
