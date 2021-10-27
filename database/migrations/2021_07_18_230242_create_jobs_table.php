<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string("title",80);
            $table->smallInteger("vacancy")->default(0);
            $table->integer("deadline");
            $table->text("description");
            $table->string("responsibilities",2000)->nullable();
            $table->string("education_experience",2000)->nullable();
            $table->string("other_benefits",2000)->nullable();
            $table->smallInteger("employment_status");
            $table->smallInteger("seniority");
            $table->foreignId("city_id")->constrained("cities")->cascadeOnDelete();
            $table->foreignId("company_id")->constrained("companies")->cascadeOnDelete();
            $table->foreignId("area_id")->nullable()->constrained("areas")->nullOnDelete();
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
        Schema::dropIfExists('jobs');
    }
}
