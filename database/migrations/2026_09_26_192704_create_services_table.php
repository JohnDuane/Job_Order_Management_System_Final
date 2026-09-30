<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Services', function (Blueprint $table) {
            $table->id('service_id');

            $table->string('service_name');
            $table->text('job_desc')->nullable();

            $table->decimal('price', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Services');
    }
};