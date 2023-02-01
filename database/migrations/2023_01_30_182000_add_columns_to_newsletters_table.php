<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNewslettersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('newsletters', function (Blueprint $table) {
      // When the newsletter should be sent
      $table->dateTime('scheduled_at')->nullable();
      // When was the last time attempted to send
      $table->dateTime('last_attempt_at')->nullable();
      // The result of the last attempt
      $table->json('last_attempt_result')->nullable();
      
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('newsletters', function (Blueprint $table) {
      //
    });
  }
}
