<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('english_name');
            $table->string('dari_name');
            $table->string('pashto_name');
            $table->string('contact_no');
            $table->string('email');
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->text('logo')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
