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
        Schema::create('report_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->integer('type')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->unsignedBigInteger('from_user');
            $table->unsignedBigInteger('to_user');
            $table->integer('is_readed')->default(0);
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_notifications');
    }
};
