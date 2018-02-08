<?php namespace Smartshop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBindingsTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_bindings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            // States
            $table->boolean('is_active')->default(0);
            $table->boolean('is_searchable')->default(0);
            // Relations
            $table->integer('binding_type_id')->unsigned()->nullable();
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('smartshop_product_binding', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('binding_id')->unsigned();
            $table->primary(['product_id', 'binding_id']);
        });

        Schema::create('smartshop_binding_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('page')->nullable();
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_bindings');
        Schema::dropIfExists('smartshop_product_binding');
        Schema::dropIfExists('smartshop_binding_types');
    }
}
