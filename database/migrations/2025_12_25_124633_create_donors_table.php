<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('donors', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->unique()->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->string('contact');
      $table->string('division');
      $table->string('district');
      $table->string('sub_district');
      $table->string('address');
      $table->string('blood_group');
      $table->string('last_donation_date')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('donors');
  }
};
