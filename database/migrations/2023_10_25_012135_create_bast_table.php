<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bast', function (Blueprint $table) {
            $table->increments('id_bast');
            $table->string('pono', 50);
            $table->string('offerno', 50);
            $table->string('bastno', 50);
            $table->date('bastdt');
            $table->date('workstart');
            $table->date('workend');
            $table->text('workdesc')->nullable();
            $table->integer('workqty');
            $table->string('copypofile');
            $table->string('reportfile');
            $table->string('createdby');
            $table->string('supplier_id');
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
        Schema::dropIfExists('bast');
    }
}
