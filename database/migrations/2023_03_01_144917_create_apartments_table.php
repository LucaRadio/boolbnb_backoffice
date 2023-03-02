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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedTinyInteger('n_rooms');
            $table->unsignedTinyInteger('n_bathrooms');
            $table->unsignedTinyInteger('n_beds');
            $table->unsignedMediumInteger('square_meters');
            $table->string('address');
            $table->boolean('visibility')->nullable()->default(1);
            $table->string('img_cover');
            $table->text('description');
            $table->float('latitude', 10, 5);
            $table->float('longitude', 10, 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
