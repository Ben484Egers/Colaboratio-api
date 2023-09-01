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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->date('deadline')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('assigned_by_id');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->boolean('completed');
            // $table->timestamps('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
