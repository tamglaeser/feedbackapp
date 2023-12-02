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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('review');
            $table->integer('rating');
            $table->string('start_date');
            $table->string('address');
            $table->string('appartments');
            $table->string('source');
            $table->timestamps();

            $table->unique(['review', 'rating', 'start_date', 'address', 'appartments', 'source']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
