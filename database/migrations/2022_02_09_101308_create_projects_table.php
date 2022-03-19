<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('buildings')->nullable();
            $table->integer('units')->nullable();
            $table->integer('available_units')->nullable();
            $table->text('description');
            $table->text('location')->nullable();
            $table->text('location_features')->nullable();
            $table->text('file')->nullable();
            $table->integer('viewed_number')->nullable();
            $table->text('photos')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('categories');
    }
}
