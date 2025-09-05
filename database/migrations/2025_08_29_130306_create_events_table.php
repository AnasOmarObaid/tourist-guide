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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->restrictOnDelete()->onUpdate('cascade'); // this event belongs to city
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable(); // the event may take hole day or many of days
            $table->string('venue')->nullable(); // the name of location for event
            $table->string('organizer'); // the name of event organizer
            $table->decimal('lat');
            $table->decimal('lng');
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
