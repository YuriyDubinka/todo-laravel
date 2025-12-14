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
            $table->id(); // Це автоматично створює id INTEGER PRIMARY KEY AUTOINCREMENT
            $table->string('title'); // title VARCHAR(255)
            $table->boolean('is_completed')->default(false); // TINYINT(1)
            $table->timestamps(); // Створює ДВІ колонки: created_at та updated_at
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
