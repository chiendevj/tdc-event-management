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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('location');
            $table->text('event_photo');
            $table->timestamp('event_start')->useCurrent();
            $table->timestamp('event_end')->useCurrent();
            $table->integer('point')->default(4);
            $table->timestamp('registration_start')->useCurrent();
            $table->timestamp('registration_end')->useCurrent();
            $table->integer('registration_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
