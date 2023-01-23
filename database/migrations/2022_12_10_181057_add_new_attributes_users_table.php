<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('web_site')->nullable();
            $table->text('presentation')->nullable();
            $table->boolean('stutus')->default(0);
            $table->string('nick_name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('web_site');
            $table->dropColumn('presentation');
            $table->dropColumn('stutus')->default(0);
            $table->dropColumn('nick_name');
        });
    }
};
