<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->time('peak_hour')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->dropColumn('peak_hour');
        });
    }
};
