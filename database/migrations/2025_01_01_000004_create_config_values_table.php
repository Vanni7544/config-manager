<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('config_variable_id')
                  ->constrained('config_variables')
                  ->cascadeOnDelete();

            $table->foreignId('config_environment_id')
                  ->constrained('config_environments')
                  ->cascadeOnDelete();

            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['config_variable_id', 'config_environment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_values');
    }
};
