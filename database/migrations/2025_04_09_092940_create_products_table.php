<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_file');
            $table->double('product_price');
            $table->text('product_description')->nullable();
            $table->integer('quantity');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
