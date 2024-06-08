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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name')->unique();
            $table->unsignedBigInteger('asset_type_id')->nullable();
            $table->foreign('asset_type_id')->references('id')->on('asset_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('serial_number')->nullable();
            $table->string('value')->nullable();
            $table->string('location')->nullable();
            $table->enum('status',['available','non-functional','lost','damaged','under-maintenance']);
            $table->string('description')->nullable();
            $table->string('asset_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
