<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_product_category', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id', 'product_id_fk_1396941')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('product_category_id');
            $table->foreign('product_category_id', 'product_category_id_fk_1396941')->references('id')->on('product_categories')->onDelete('cascade');
        });

    }
}
