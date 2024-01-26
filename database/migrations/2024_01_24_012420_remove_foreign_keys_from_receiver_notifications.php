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
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receiver_notifications', function (Blueprint $table) {
            //
        });
    }
};
