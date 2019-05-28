<?php namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIndustriesTable extends Migration
{
    public function up()
    {
        Schema::create('depcore_portfolio_industries', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->unsigned (  )->nullable (  );
            $table->string ( 'name' );
            $table->integer('sort_order')->default ( 0 );
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depcore_portfolio_industries');
    }
}
