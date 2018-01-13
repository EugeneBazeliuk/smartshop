<?php namespace SmartShop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_catalog_meta', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            // Relation
            $table->nullableMorphs('taggable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_catalog_meta');
    }
}
