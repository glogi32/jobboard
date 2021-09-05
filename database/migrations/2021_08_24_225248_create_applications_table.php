<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string("first_name", 60);
            $table->string("last_name", 60);
            $table->string("email",120);
            $table->string("phone", 25);
            $table->string("github",255)->nullable();
            $table->string("linkedin",255)->nullable();
            $table->string("portfolio_website",255)->nullable();
            $table->text("message")->nullable();
            $table->smallInteger("status");
            $table->foreignId("user_cvs_id")->nullable()->constrained("user_cvs")->nullOnDelete();
            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignId("job_id")->constrained("jobs")->cascadeOnDelete();
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
        Schema::dropIfExists('applications');
    }
}
