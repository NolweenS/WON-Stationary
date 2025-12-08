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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->string('order_number')->unique();
            //totaalbedrag
            $table->decimal('total_price',10,2);
            //status van de betaling
            $table->enum('status',['pending','processing','completed','cancelled'])->default('pending');
            //Verzendgegevens
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
