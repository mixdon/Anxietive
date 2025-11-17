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
        Schema::create('tb_log_ip', function (Blueprint $table) {
            $table->id();
            $table->string('class_function'); 
            $table->integer('status_code'); 
            $table->text('msg');
            $table->timestamp('insert_at')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_ip');
    }
};
