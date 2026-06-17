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
        Schema::create('assets', function (Blueprint $table) {
           $table->ulid('id')->primary();

            $table->foreignUlid('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('asset_tag');

            $table->string('serial_number')
                ->nullable();

            $table->string('name');

            $table->foreignId('asset_category_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('asset_model_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('asset_status_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('assigned_employee_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->date('purchase_date')
                ->nullable();

            $table->decimal('purchase_cost', 15, 2)
                ->nullable();

            $table->string('invoice_number')
                ->nullable();

            $table->unsignedInteger('depreciation_months')
                ->nullable();

            $table->decimal('residual_value', 15, 2)
                ->nullable();

            $table->date('warranty_expiration_date')
                ->nullable();

            $table->string('criticality', 20)
                ->nullable();

            $table->string('business_service')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->foreignUlid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'tenant_id',
                'asset_tag'
            ]);

            $table->index('tenant_id');
            $table->index('asset_status_id');
            $table->index('assigned_employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
