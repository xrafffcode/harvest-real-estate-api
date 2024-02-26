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
        Schema::create('property_type_pivot', function (Blueprint $table) {
            $table->id();
            $table->uuid('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->uuid('property_type_id');
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_type_pivot');
    }
};
