<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_package', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->integer('quantity')->default(1); // Jumlah paket dalam langganan
            $table->decimal('subtotal', 10, 2)->default(0); // Total harga dari paket yang dipilih
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_package');
    }
};
