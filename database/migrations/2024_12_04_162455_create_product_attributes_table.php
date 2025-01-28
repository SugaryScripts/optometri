<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->enum('data_type', ['string', 'number', 'boolean']); // e.g., "string", "number", "boolean"
            $table->boolean('required')->default(false);

            $table->foreignId('product_type_id')
                ->constrained('product_types')
                ->cascadeOnDelete()
                ->cascadeOnUpdate(); // Link to product type

            $table->timestamps();
        });

        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();

            $table->foreignId('product_attribute_id')
                ->constrained('product_attributes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate(); // Link to product type
            $table->morphs('attributable'); // Polymorphic relation (creates attributable_type and attributable_id)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_attribute_values');
    }
};
