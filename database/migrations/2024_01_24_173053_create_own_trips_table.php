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
        Schema::create('own_trips', function (Blueprint $table) {
            $table->id();
            $table->string("trip_type")->nullable();
            $table->integer("member_count")->nullable();
            $table->integer("number_of_days")->nullable();
            $table->string("arrival_date")->nullable();
            $table->string("description")->nullable();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->string("country")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('own_trips');
    }
};
