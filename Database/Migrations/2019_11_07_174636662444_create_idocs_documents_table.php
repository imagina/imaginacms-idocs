<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdocsDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idocs__documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('user_identification')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('role')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->text('options')->nullable();
            $table->foreign('category_id')->references('id')->on('idocs__categories')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
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
        Schema::dropIfExists('idocs__documents');
    }
}
