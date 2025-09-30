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
        Schema::create('repair_services', function (Blueprint $table) {
            $table->id();
            $table->string('repair_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('device_brand');
            $table->string('device_model');
            $table->string('device_imei')->nullable();
            $table->text('problem_description');
            $table->text('repair_notes')->nullable();
            $table->decimal('estimated_cost', 10, 2)->default(0);
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->enum('status', ['pending', 'diagnosed', 'in_progress', 'completed', 'delivered', 'cancelled'])->default('pending');
            $table->date('received_date');
            $table->date('estimated_completion')->nullable();
            $table->date('completed_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->string('technician')->nullable();
            $table->text('warranty_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_services');
    }
};
