<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('news', function (Blueprint $table) {
      $table->id();
      $table->string("title");
      $table->string("content");
      $table->string("coverImg");
      $table->string("createdBy")->nullable(false);
      $table->string("startAt");
      $table->string("endAt");
      $table->boolean("active")->default(true);
//      $table->array("attachments");
      $table->timestamps();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('news');
  }
}
