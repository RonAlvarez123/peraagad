<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type');
            $table->decimal('amount');
            $table->string('account_name')->nullable()->default('null');
            $table->string('account_number')->nullable()->default('null');
            $table->string('bank_name')->nullable()->default('null');
            $table->string('recipient_name')->nullable()->default('null');
            $table->string('phone_number')->nullable()->default('null');
            $table->string('municipality')->nullable()->default('null');
            $table->string('province')->nullable()->default('null');
            $table->string('address')->nullable()->default('null');
            $table->timestamp('requested_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashouts');
    }
}
