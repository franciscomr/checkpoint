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
        Schema::create('employees', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_id')->constrained()->cascadeOnDelete();
            $table->index('tenant_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('employee_code')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->cascadeOnDelete();
            $table->index('branch_id');
            $table->foreignId('department_id')->nullable()->constrained()->cascadeOnDelete();
            $table->index('department_id');
            $table->foreignId('position_id')->nullable()->constrained()->cascadeOnDelete();
            $table->index('position_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('hire_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unique(['tenant_id', 'employee_code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
