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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUlid('tenant_id')->constrained()->nullOnDelete();
            $table->index('tenant_id');
            $table->foreignUlid('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('avatar_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unique(['tenant_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['employee_id']);
            $table->dropColumn(['tenant_id', 'employee_id', 'avatar_url', 'is_active']);
            $table->dropUnique(['tenant_id', 'email']);
        });
    }
};
