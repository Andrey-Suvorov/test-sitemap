<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitemapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitemap', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias')->unique();
            $table->double('priority', 2, 1)->default(0);
            $table->date('lastmod')->nullable();
            $table->string('changefreq')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_loaded')->default(false);
            $table->integer('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sitemap');
    }
}
