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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->restrictOnDelete()->onUpdate('cascade'); // this hotel belongs to city
            $table->string('name')->unique();
            $table->string('venue');
            $table->string('owner'); // the name of hotel owner
            $table->decimal('price_per_night', 10, 2);
            $table->unsignedTinyInteger('rate')->default(3); // 1-5
            $table->text('description')->nullable();
            $table->string('cover')->nullable()->comment('image cover');
            $table->decimal('lat');
            $table->decimal('lng');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
