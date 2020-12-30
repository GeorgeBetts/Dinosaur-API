<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeComparisonToDinosaursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dinosaurs', function (Blueprint $table) {
            $table->string('size_comparison', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dinosaurs', function (Blueprint $table) {
            $table->dropColumn('size_comparison');
        });
    }
}
