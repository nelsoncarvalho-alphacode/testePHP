<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_product');
            $table->integer('amount_Buy');
            $table->decimal('value_unit');
            $table->decimal('percentage_descount');
            $table->decimal('amount_Buy_descount');
            $table->unsignedBigInteger('id_status');
            $table->foreign('id_client')->references('id')->on('clients');
            $table->foreign('id_status')->references('id')->on('status');
            $table->foreign('id_product')->references('id')->on('products');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
