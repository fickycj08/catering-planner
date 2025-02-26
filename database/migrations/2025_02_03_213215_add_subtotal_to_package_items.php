<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('package_items', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('quantity')->default(0);
        });
    }

    public function down()
    {
        Schema::table('package_items', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};
