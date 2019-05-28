<?php namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('depcore_portfolio_categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string ( 'name' );
            $table->string ( 'slug' );
            $table->integer('sort_order')->default ( 0 );
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depcore_portfolio_categories');
    }
}
