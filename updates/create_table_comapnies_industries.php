<?php namespace Depcore\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCompaniesIndustriesTable extends Migration
{
    public function up()
    {
        Schema::create('depcore_portfolio_companies_industries', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('client_id');
            $table->integer('industry_id');
            $table->integer('relation_sort_order')->default ( 0 )->unsigned (  );
        });
    }

    public function down()
    {
        Schema::dropIfExists('depcore_portfolio_companies_industries');
    }
}
