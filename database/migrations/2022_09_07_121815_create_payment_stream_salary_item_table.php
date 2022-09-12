<?php

use App\Models\PaymentStream;
use App\Models\SalaryItem;
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
        Schema::create('payment_stream_salary_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaymentStream::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SalaryItem::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('payment_stream_salary_item');
    }
};
