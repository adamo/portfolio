<?php

namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateIndustryTable1 extends Migration
{
    public function up()
    {
        Schema::table('depcore_portfolio_industries', function (Blueprint $table) {
            $table->string('slug');
        });
    }

    public function down()
    {
        Schema::table('depcore_portfolio_industries', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
