<?php namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class DepcoreCreateClientsTable extends Migration
{
    public function up()
    {
         Schema::create('depcore_portfolio_clients', function($table)
         {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('brand_color', 7 )->nullable (  );
            $table->text('description')->nullable(  );
            $table->string('logo')->nullable(  );
            $table->string('logo_mark')->nullable(  );
            $table->string('logo_black_white')->nullable(  );
            $table->string ( 'website_url' )->nullable(  );
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('depcore_portfolio_clients');
    }
}