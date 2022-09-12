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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->foreignId('designation_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('office_type_id')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->date('company_doj')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('savings_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->decimal('basic_salary',10)->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('religion')->nullable();
            $table->string('lga')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->string('guarantor_1')->nullable();
            $table->string('guarantor_1_address')->nullable();
            $table->string('guarantor_2')->nullable();
            $table->string('guarantor_2_address')->nullable();
            $table->string('guarantor_3')->nullable();
            $table->string('guarantor_3_address')->nullable();
            $table->string('guarantor_1_phone')->nullable();
            $table->string('guarantor_2_phone')->nullable();
            $table->string('guarantor_3_phone')->nullable();
            $table->tinyInteger('level')->nullable();
            $table->string('staff_id')->nullable();
            $table->date('dob')->nullable();
            $table->string('photo')->default('photos/default.png');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
