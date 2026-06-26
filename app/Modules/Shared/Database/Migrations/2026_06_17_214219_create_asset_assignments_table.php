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
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('asset_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('employee_id')->constrained()->cascadeOnDelete();

            $table->timestamp('assigned_at');
            $table->timestamp('expected_return_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->text('assignment_notes')->nullable();
            $table->text('return_notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

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
        Schema::dropIfExists('asset_assignments');
    }
};
