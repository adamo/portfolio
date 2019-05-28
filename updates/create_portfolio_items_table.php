<?php namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePortfolioItemsTable extends Migration
{
    public function up()
    {
        Schema::create('depcore_portfolio_items', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer ( 'client_id' )->unsigned (  )->nullable (  );
            $table->string ( 'title' );
            $table->string ( 'slug' );
            $table->string ( 'meta_title' );
            $table->string ( 'meta' )->nullable (  );
            $table->string ( 'url' )->nullable (  );
            $table->boolean ( 'published' )->default ( 0 );
            $table->text('short_description')->nullable (  );
            $table->text('description')->nullable (  );
            $table->text('content')->nullable (  );
            $table->integer('sort_order')->default ( 0 );
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depcore_portfolio_items');
    }
}