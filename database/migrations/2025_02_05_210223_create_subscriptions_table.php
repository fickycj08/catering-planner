<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->decimal('total_price', 10, 2)->default(0); // Total harga dari semua paket
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->date('start_date'); // Tanggal mulai langganan
            $table->date('end_date'); // Tanggal berakhir langganan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
