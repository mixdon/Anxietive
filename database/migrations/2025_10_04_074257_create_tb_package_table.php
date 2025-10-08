<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_package', function (Blueprint $table) {
            $table->id();
            $table->string('judul_package', 200)->nullable();
            $table->foreignId('id_office')->nullable()->constrained('tb_offices')->nullOnDelete();
            $table->integer('times')->nullable(); 
            $table->integer('amount')->nullable(); 
            $table->string('image', 300)->nullable();
            $table->text('description')->nullable(); 
            $table->json('detail_duration')->nullable(); 
            $table->timestamp('insert_at')->nullable();   
            $table->timestamp('deleted_at')->nullable();  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_package');
    }
};
