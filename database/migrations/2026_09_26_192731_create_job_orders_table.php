<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Job_Order', function (Blueprint $table) {
            $table->id('job_order_id');

            $table->foreignId('cust_id')
                ->constrained('Customer', 'cust_id')
                ->restrictOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('Vehicle', 'vehicle_id')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->text('problem_description');
            $table->text('remarks')->nullable();

            $table->string('status');

            $table->date('date_issued');
            $table->date('expected_empl_date')->nullable();

            $table->decimal('total_cost', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Job_Order');
    }
};