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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('prospectus_id');
            $table->integer('course_id');
            $table->string('subject_code');
            $table->string('description');
            $table->string('pre_requisites');
            $table->string('lec_units');
            $table->string('lab_units');
            $table->string('year_lvl');
            $table->string('semester');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
