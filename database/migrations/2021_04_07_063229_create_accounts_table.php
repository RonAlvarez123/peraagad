<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('money')->default(0);
            $table->string('level')->default('basic');
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->bigInteger('direct')->default(0);
            $table->bigInteger('indirect')->default(0);
            $table->string('role')->default('user');
            $table->integer('number_of_bonus_claimed')->default(0);
            $table->timestamp('bonus_claimed_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
