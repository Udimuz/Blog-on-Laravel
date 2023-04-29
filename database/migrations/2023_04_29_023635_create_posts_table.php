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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');

			// Поле таблицы, необходимо для ключей-отношений:
			$table->unsignedBigInteger('category_id')->nullable();
			// IDX:
			$table->index('category_id', 'post_category_idx');
			// FK:
			$table->foreign('category_id', 'post_category_fk')->on('categories')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
