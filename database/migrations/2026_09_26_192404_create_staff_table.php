<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Staff', function (Blueprint $table) {
            $table->id('staff_id');

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('staff_first');
            $table->string('staff_middle')->nullable();
            $table->string('staff_last');

            $table->string('contact_number', 15);
            $table->string('address');

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Staff');
    }
};