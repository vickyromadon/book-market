<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->enum('status', ['payment', 'approve', 'reject', 'pending', 'done', 'cancel'])->default('pending');
            $table->bigInteger('shipping')->default(0)->nullable();
            $table->bigInteger('subtotal')->default(0)->nullable();
            $table->bigInteger('total')->default(0)->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');

            $table->unsignedBigInteger('depature_location_id')->default(null)->nullable();
            $table->foreign('depature_location_id', 'fk_depature_location')->references('id')->on('locations')->onDelete('cascade');

            $table->unsignedBigInteger('destination_location_id')->default(null)->nullable();
            $table->foreign('destination_location_id', 'fk_destination_location')->references('id')->on('locations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
