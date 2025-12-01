<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                ->constrained('tb_package')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('tb_customer')
                ->nullOnDelete();

            $table->string('fullname', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->text('message')->nullable();

            $table->date('date');
            $table->time('time');

            $table->string('img_bukti_trf', 300)->nullable();

            $table->enum('status', [
                'pending',
                'completed',
                'cancelled',
                'refund',
                'draft'
            ])->default('pending');

            $table->string('kode_invoice', 200)->nullable();
            $table->integer('no_urut')->nullable();

            $table->foreignId('office_id')
                ->nullable()
                ->constrained('tb_office')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_bookings');
    }
};