<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('addressee');
            $table->string('address');
            $table->string('city');
            $table->string('payment_id', 20)->nullable(true);
            $table->integer('verified_by')->nullable(true);
            $table->integer('delivery_time')->nullable(true);
            $table->enum('status', 
            ['Estamos verificando su pago', 
            'Pago verificado, estamos preparando el su pedido',
            'Pedido enviado o listo para retirar']);
            $table->float('shipping_cost')->nullable(true);
            $table->string('mail_company')->nullable(true);
            $table->string('tracking_code')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
