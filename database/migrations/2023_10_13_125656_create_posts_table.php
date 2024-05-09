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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('url')->nullable();
            $table->foreignId('community_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->integer('likes');
            $table->integer('dislikes');
            $table->timestamps();

//            $table->foreign('community_id')->references('idComm')->on('communities')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
