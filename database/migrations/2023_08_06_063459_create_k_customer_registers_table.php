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
        Schema::create('k_customer_registers', function (Blueprint $table) {
            $table->id();
            $table->string('comname');
            $table->string('name');
            $table->string('phone');
            $table->string('mobile')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->string('serialNo')->nullable()->default(NULL);
            $table->string('gstno')->nullable()->default(NULL);
            $table->string('refname')->nullable()->default(NULL);
            $table->string('pack')->nullable()->default(NULL);
            $table->string('billtype')->nullable()->default(NULL);
            $table->string('software')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_customer_registers');
    }
};
