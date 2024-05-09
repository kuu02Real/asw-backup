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
        Schema::create('usersInCommunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
//            $table->unsignedBigInteger('user_id');
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('community_id')->references('idComm')->on('communities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersInCommunities');
    }
};
