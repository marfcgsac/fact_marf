<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantPosSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_sales', function (Blueprint $table) {
            $table->increments('id');

            // unity
            $table->integer('document_id')->unsigned();
            $table->integer('pos_id')->unsigned();

            // data
            $table->float('total', 15, 4);
            $table->float('payed', 15, 4);
            $table->float('delta', 15, 4);

            // log
            $table->timestamps();
            $table->softDeletes();

            // link
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('pos_id')->references('id')->on('pos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_sales');
    }
}
