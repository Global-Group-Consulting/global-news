<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatesColumnInFaqsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('faqs', function (Blueprint $table) {
      $table->boolean("active")->default(0)->change();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faqs', function (Blueprint $table) {
      $table->boolean("active")->default(1)->change();
    });
  }
}
