<?php
namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdatePortfolioItemsTable1 extends Migration
{
    public function up()
    {
        Schema::table('depcore_portfolio_items', function (Blueprint $table) {
            $table->dropColumn('meta_title','meta');
        });
    }

    public function down()
    {
        Schema::table('depcore_portfolio_items', function (Blueprint $table) {
            $table->string('meta_title');
            $table->string('meta')->nullable();
        });
    }
}
