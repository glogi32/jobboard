<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string("first_name", 60);
            $table->string("last_name", 60);
            $table->string("email",120)->unique();
            $table->string("password", 120);
            $table->string("phone", 25);
            $table->string("github",255)->nullable();
            $table->string("linkedin",255)->nullable();
            $table->string("portfolio_link",255)->nullable();
            $table->text("about_me")->nullable();
            $table->timestamp("banned")->nullable();
            $table->integer("verified")->nullable();
            $table->bigInteger("verification_number")->nullable();
            $table->foreignId("role_id")->constrained("roles")->restrictedOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
