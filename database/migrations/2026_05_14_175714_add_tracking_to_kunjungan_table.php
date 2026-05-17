<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kunjungan', function (Blueprint $table) {
            $table->string('lat_visit')->nullable()->after('updated_at');
            $table->string('lng_visit')->nullable()->after('lat_visit');
        });
    }

    public function down()
    {
        Schema::table('kunjungan', function (Blueprint $table) {
            $table->dropColumn(['lat_visit', 'lng_visit']);
        });
    }
};
