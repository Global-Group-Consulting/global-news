<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFaqsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('faqs', function (Blueprint $table) {
      $table->after("answer", function ($table) {
        $table->boolean("active")->default(true);
      });
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faqs', function (Blueprint $table) {
      $table->dropColumn("status");
    });
  }
}
