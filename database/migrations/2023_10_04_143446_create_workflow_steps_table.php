<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateWorkFlowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->text('name')->nullable();
            $table->text('next_step')->nullable();
            $table->enum('actions', ['view','print','approve','reject','draft','terminate-workflow'])->nullable();
            $table->integer('created_by');
            $table->softDeletes();
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
        Schema::dropIfExists('workflow_steps');
    }
}
