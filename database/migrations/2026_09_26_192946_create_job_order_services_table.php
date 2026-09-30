<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Job_Order_Services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_order_id')
                ->constrained('Job_Order', 'job_order_id')
                ->restrictOnDelete();

            $table->foreignId('service_id')
                ->constrained('Services', 'service_id')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Job_Order_Services');
    }
};