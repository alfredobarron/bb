<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePossessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possessions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('description');
            $table->boolean('favorite')->default(false);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('possession_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('file');
            $table->integer('possession_id')->unsigned();
            $table->foreign('possession_id')->references('id')->on('possessions');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('possession_tag', function (Blueprint $table) {
            $table->integer('possession_id');
            $table->integer('tag_id');
            $table->primary(['possession_id', 'tag_id']);
        });

        Schema::create('possession_share', function (Blueprint $table) {
            $table->integer('possession_id');
            $table->integer('user_id');
            $table->primary(['possession_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possession_tag');
        Schema::dropIfExists('possession_share');
        Schema::dropIfExists('possession_files');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('possessions');
    }
}
