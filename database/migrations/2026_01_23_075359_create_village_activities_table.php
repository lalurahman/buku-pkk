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
        Schema::create('village_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('village_id');
            $table->foreignId('sub_activity_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->date('finish_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_activities');
    }
};
