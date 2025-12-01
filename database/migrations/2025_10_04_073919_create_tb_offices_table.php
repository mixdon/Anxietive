<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_offices', function (Blueprint $table) {
            $table->id();

            $table->string('office_name', 200)->nullable();
            $table->string('address', 300)->nullable();

            $table->string('email_kantor', 200)->nullable();
            $table->string('no_wa_kantor', 100)->nullable();

            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();

            $table->string('kode_office', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_offices');
    }
};