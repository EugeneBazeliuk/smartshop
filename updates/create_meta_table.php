<?php namespace SmartShop\Catalog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('smartshop_meta', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->enum('robot_index', ['index', 'noindex'])->nullable();
            $table->enum('robot_follow', ['follow', 'nofollow'])->nullable();
            // Relation
            $table->nullableMorphs('taggable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('smartshop_meta');
    }
}
