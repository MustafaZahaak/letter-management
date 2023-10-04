<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateLetterRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('random_unique_field')->unique()->default(Str::random(10));
            $table->text('letter_id')->nullable();
            $table->enum('status', ['draft','completed', 'rejected'])->default('draft');
            $table->text('job_status')->nullable();
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
        Schema::dropIfExists('letter_requests');
    }
}
