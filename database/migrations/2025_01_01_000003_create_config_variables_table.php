<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_variables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('config_project_id')
                  ->constrained('config_projects')
                  ->cascadeOnDelete();

            $table->string('key');
            $table->string('type')->default('string');
            $table->boolean('required')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['config_project_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_variables');
    }
};
