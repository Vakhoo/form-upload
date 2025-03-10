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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('path')->index();
            $table->string('extension')->nullable()->index();
            $table->string('mime')->nullable()->index();
            $table->unsignedBigInteger('size')->index();
            $table->string('filename')->nullable()->index();
            $table->string('hash')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
