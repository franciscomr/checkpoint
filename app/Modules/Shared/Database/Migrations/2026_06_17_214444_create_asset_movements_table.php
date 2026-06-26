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
        Schema::create('asset_movements', function (Blueprint $table) {

            $table->ulid('id')->primary();

            $table->foreignUlid('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('asset_id')->constrained()->cascadeOnDelete();

            $table->string('movement_type');

            $table->foreignUlid('from_employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignUlid('to_employee_id')->nullable()->constrained('employees')->nullOnDelete();

            $table->foreignId('from_status_id')->nullable()->constrained('asset_statuses')->nullOnDelete();
            $table->foreignId('to_status_id')->nullable()->constrained('asset_statuses')->nullOnDelete();

            $table->text('movement_notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('performed_at');

            $table->timestamp('created_at')->useCurrent();

            $table->index([
                'tenant_id',
                'asset_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_movements');
    }
};
