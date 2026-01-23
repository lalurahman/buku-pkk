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
        Schema::create('meeting_minutes', function (Blueprint $table) {
            $table->id();
            $table->date('meeting_date');
            $table->string('location');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('meeting_type')->nullable();
            $table->string('leader')->nullable();
            $table->integer('invited_count')->nullable();
            $table->integer('attended_count')->nullable();
            $table->text('agenda')->nullable();
            $table->text('discussion')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('follow_up')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_minutes');
    }
};
