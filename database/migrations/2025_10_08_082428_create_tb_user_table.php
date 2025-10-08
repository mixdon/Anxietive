<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id();
            $table->string('username', 200)->unique();
            $table->string('password', 200);
            $table->string('fullname', 200)->nullable();
            $table->foreignId('office')->nullable()->constrained('tb_offices')->nullOnDelete();
            $table->foreignId('roles')->nullable()->constrained('tb_roles')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};