<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_customer', function (Blueprint $table) {
            $table->id();
            $table->string('email', 200)->unique();
            $table->string('password', 255);
            $table->string('fullname', 200);
            $table->string('phone', 20)->nullable()->index();
            $table->enum('status_aktif', ['pending','verified','inactive','banned'])
                  ->default('pending')->comment('pending = belum verifikasi OTP');
            $table->string('otp_code', 10)->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->dateTime('insert_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_customer');
    }
};
