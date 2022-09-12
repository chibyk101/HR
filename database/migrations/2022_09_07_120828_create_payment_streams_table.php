<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_streams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('process_deductions')->default(false);
            $table->boolean('include_basic_salary')->default(false);
            $table->boolean('include_overtime')->default(false);
            $table->timestamp('processed_at')->nullable();
            $table->string('payment_month');
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
        Schema::dropIfExists('payment_streams');
    }
};
