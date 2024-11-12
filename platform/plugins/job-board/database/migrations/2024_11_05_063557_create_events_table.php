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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            // Existing fields
            $table->string('day')->nullable();
            $table->unsignedInteger('year')->nullable();
            $table->date('date')->nullable();
            $table->integer('flag')->default(0)->nullable();
            
            // New fields for superadmin, consultant, and user
            $table->unsignedBigInteger('superadmin_id')->nullable();
            $table->unsignedBigInteger('consultant_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            
            // Start and end time for the event
            $table->string('start_time', 20)->nullable();
            $table->string('end_time', 20)->nullable();
            
            
            // Meeting links
            $table->string('jobseekermeetlink',255)->nullable();
            $table->string('employermeetlink',255)->nullable();
            $table->string('consultantmeetlink',255)->nullable();
            $table->string('adminmeetlink',255)->nullable();
            
            // New fields for tokens
            $table->string('jobseekertoken')->nullable();
            $table->string('employertoken')->nullable();
            $table->string('consultanttoken')->nullable();
            $table->string('admintoken')->nullable();
        
            // Timestamps
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
        Schema::dropIfExists('events');
    }
};
