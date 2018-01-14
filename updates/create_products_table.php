<?php namespace Smartshop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('isbn')->unique()->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->text('description')->nullable();
            // Sizes
            $table->double('width', 10, 2)->nullable();
            $table->double('height', 10, 2)->nullable();
            $table->double('depth', 10, 2)->nullable();
            $table->double('weight', 10, 2)->nullable();
            // States
            $table->boolean('is_active')->default(0);
            $table->boolean('is_searchable')->default(0);
            $table->boolean('is_unique_text')->default(0);
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_products');
    }
}
