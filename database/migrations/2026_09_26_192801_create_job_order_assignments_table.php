<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Job_Order_Assignment', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_order_id')
                ->constrained('Job_Order', 'job_order_id')
                ->restrictOnDelete();

            $table->foreignId('staff_id')
                ->constrained('Staff', 'staff_id')
                ->restrictOnDelete();

            $table->foreignId('assigned_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->date('assigned_date');

            $table->text('remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Job_Order_Assignment');
    }
};