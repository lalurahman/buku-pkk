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
        Schema::create('letter_dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_letter_id')->constrained()->onDelete('cascade');
            $table->string('disposition_to');
            $table->text('instructions')->nullable();
            $table->date('disposition_date')->nullable();
            $table->string('from')->nullable(); // Ketua TP PKK
            $table->enum('priority', ['normal', 'important', 'urgent'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_dispositions');
    }
};
