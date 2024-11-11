
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('product_id')->constrained()->after('id')->onDelete('cascade');
            $table->string('email');
            $table->string('address');
            $table->string('city');
            $table->string('payment_method');
            $table->decimal('total', 10, 2); // Total amount
             $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
       
            $table->dropColumn('product_id');
       
    }
}
