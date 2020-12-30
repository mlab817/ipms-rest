<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->decimal('t2016',20,2)->default(0);
            $table->decimal('t2017',20,2)->default(0);
            $table->decimal('t2018',20,2)->default(0);
            $table->decimal('t2019',20,2)->default(0);
            $table->decimal('t2020',20,2)->default(0);
            $table->decimal('t2021',20,2)->default(0);
            $table->decimal('t2022',20,2)->default(0);
            $table->decimal('t2023',20,2)->default(0);
            $table->decimal('t2024',20,2)->default(0);
            $table->decimal('t2025',20,2)->default(0);
            $table->decimal('i2016',20,2)->default(0);
            $table->decimal('i2017',20,2)->default(0);
            $table->decimal('i2018',20,2)->default(0);
            $table->decimal('i2019',20,2)->default(0);
            $table->decimal('i2020',20,2)->default(0);
            $table->decimal('i2021',20,2)->default(0);
            $table->decimal('i2022',20,2)->default(0);
            $table->decimal('i2023',20,2)->default(0);
            $table->decimal('i2024',20,2)->default(0);
            $table->decimal('i2025',20,2)->default(0);
            $table->timestamps();

            $table->unique(['project_id','region_id'], 'pri_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_investments');
    }
}