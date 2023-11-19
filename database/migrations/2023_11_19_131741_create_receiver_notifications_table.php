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
        Schema::create('receiver_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_notification_id');
            $table->unsignedBigInteger('receiver_ids');
            $table->timestamps();
        
            $table->foreign('report_notification_id')->references('id')->on('report_notifications')->onDelete('cascade');
            $table->foreign('receiver_ids')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiver_notifications');
    }
};
