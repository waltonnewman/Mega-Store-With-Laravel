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
        Schema::create('product_variants', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('product_id'); // Foreign key for product
            $table->string('variant_name'); // e.g., Color, Size
            $table->string('variant_value'); // e.g., Red, Large
            $table->decimal('price', 10, 2)->nullable(); // Variant price can be different
            $table->integer('quantity')->default(0); // Stock quantity for this variant
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
