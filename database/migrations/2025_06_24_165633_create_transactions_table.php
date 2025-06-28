<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('ticket_id');
            $table->string('order_id')->nullable();
            $table->string('event_name_snapshot')->nullable();
            $table->string('ticket_name_snapshot')->nullable();
            $table->integer('ticket_price_snapshot')->nullable();
            $table->integer('quantity');
            $table->decimal('total_amount', 10, 2);
            $table->string('status');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('snap_token')->nullable();
            $table->json('payment_info')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
