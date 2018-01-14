<?php namespace Smartshop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            // NestedTree
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            // States
            $table->boolean('is_active')->default(0);
            $table->boolean('is_searchable')->default(0);
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('smartshop_categories_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->primary(['category_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_categories');
        Schema::dropIfExists('smartshop_categories_products');
    }
}
