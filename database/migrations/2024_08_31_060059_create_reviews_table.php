<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Foreign key to products table
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // Foreign key to users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Rating between 1 and 5
            $table->integer('rating')->unsigned()->default(1);
            // Review text, optional
            $table->text('review_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
