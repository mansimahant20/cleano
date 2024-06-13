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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->foreignId('lentTo')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('dateGiven');
            $table->dateTime('estimatedDateOfReturn');
            $table->dateTime('dateOfReturn')->nullable();
            $table->foreignId('returnedBy')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
