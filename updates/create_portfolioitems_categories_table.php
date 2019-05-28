<?php namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePortfolioItemsCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('depcore_portfolio_portfolio_items_categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('portfolio_item_id');
            $table->integer('category_id');
            $table->integer('relation_sort_order')->default ( 0 )->unsigned (  );
        });
    }

    public function down()
    {
        Schema::dropIfExists('depcore_portfolio_portfolio_items_categories');
    }
}
