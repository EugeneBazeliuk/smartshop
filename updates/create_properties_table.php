<?php namespace Smartshop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_properties', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            // Sortable
            $table->integer('sort_order')->default(0);
            // States
            $table->boolean('is_active')->default(false);
        });

        Schema::create('smartshop_product_property', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->integer('property_value_id')->unsigned()->nullable();
            $table->primary(['product_id', 'property_id']);
        });

        Schema::create('smartshop_property_values', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('value');
            // Relations
            $table->integer('property_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_properties');
        Schema::dropIfExists('smartshop_product_property');
        Schema::dropIfExists('smartshop_property_values');
    }
}
