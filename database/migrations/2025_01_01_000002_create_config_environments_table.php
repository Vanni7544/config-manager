<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_environments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('config_project_id')
                  ->constrained('config_projects')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->boolean('is_production')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_environments');
    }
};
