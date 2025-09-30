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
        Schema::create('warranty_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_code')->unique();
            $table->foreignId('warranty_id')->constrained()->onDelete('cascade');
            $table->date('claim_date');
            $table->text('problem_description');
            $table->text('customer_complaint');
            $table->enum('claim_type', ['repair', 'replacement', 'refund'])->default('repair');
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_progress', 'completed'])->default('pending');
            $table->text('technician_notes')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->date('resolution_date')->nullable();
            $table->string('resolved_by')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_claims');
    }
};
