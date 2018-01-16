<?php namespace SmartShop\Catalog\Updates;

use App;

/**
 * Class SeedInitial
 * @package Djetson\Shop\Updates
 */
class SeedInitial extends \October\Rain\Database\Updates\Seeder
{
    public function run()
    {
        if (App::environment() !== 'testing') {
            $this->call(\SmartShop\Catalog\Seeders\ProductSeeder::class);
            $this->call(\SmartShop\Catalog\Seeders\CategorySeeder::class);
            $this->call(\SmartShop\Catalog\Seeders\PublisherSeeder::class);
            $this->call(\SmartShop\Catalog\Seeders\PublisherSetSeeder::class);
        }
    }
}