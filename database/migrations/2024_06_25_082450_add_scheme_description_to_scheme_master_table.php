<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchemeDescriptionToSchemeMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scheme_master', function (Blueprint $table) {
            $table->text('scheme_description')->nullable()->after('scheme_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheme_master', function (Blueprint $table) {
            $table->dropColumn('scheme_description');
        });
    }
}
