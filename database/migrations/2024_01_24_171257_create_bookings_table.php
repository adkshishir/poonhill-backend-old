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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string("arrival_date")->nullable();
            $table->string("departure_date")->nullable();
            $table->string("description")->nullable();
            $table->string("counts")->nullable();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("activity_id")->constrained("activities")->onDelete("cascade");
            $table->string("status")->nullable();
            $table->string("country")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
