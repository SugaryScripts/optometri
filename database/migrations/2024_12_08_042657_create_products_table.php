<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->decimal('price', 15, 2);

            $table->foreignId('product_type_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete(); // RESTRICTED
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->timestamps();
        });


        // specifications
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('sku')->unique(); // SKU for the variant
            $table->decimal('price', 15, 2); // Price specific to the variant

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_specifications');
    }
};
