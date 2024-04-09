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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique()->nullable();
            $table->string('description')->nullable();
            $table->longText('introduction');
            $table->longText('itinerary')->nullable();
            $table->longText('includes')->nullable();
            $table->longText('good_to_know')->nullable();
            $table->json('images')->nullable();
            $table->string('vedio')->nullable();
            $table->string('price')->nullable();
            $table->string('duration')->nullable();
            $table->string('altitude')->nullable();
            $table->string('start_from')->nullable();
            $table->string('end_at')->nullable();
            $table->string('attraction')->nullable();
            $table->string('rating')->nullable();
            $table->string('culture')->nullable();
            $table->string('food')->nullable();
            $table->string('grade')->nullable();
            $table->string('season')->nullable();
            $table->string('transportation')->nullable();
            $table->string('accomodation')->nullable();
            $table->string('group_size')->nullable();
            $table->string('group_type')->nullable();
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
