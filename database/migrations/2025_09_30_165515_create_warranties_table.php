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
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();
            $table->string('warranty_code')->unique();
            $table->string('product_name');
            $table->string('product_type'); // charger, power_bank, mobile_accessory
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->date('purchase_date');
            $table->date('warranty_start_date');
            $table->date('warranty_end_date');
            $table->integer('warranty_period_months');
            $table->decimal('purchase_price', 10, 2);
            $table->text('warranty_terms')->nullable();
            $table->enum('status', ['active', 'expired', 'void'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
