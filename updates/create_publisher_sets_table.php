<?php namespace Smartshop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePublisherSetsTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_publisher_sets', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            // Relations
            $table->integer('publisher_id')->unsigned()->nullable();
            // States
            $table->boolean('is_active')->default(0);
            $table->boolean('is_searchable')->default(0);
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_publisher_sets');
    }
}