<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Vehicle', function (Blueprint $table) {
            $table->id('vehicle_id');

            $table->foreignId('cust_id')
                ->constrained('Customer', 'cust_id')
                ->restrictOnDelete();

            $table->string('plate_number');
            $table->string('make');
            $table->string('engine_model');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Vehicle');
    }
};