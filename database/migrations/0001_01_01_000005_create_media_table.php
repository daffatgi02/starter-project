<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('mediable_type')->nullable();
            $table->string('mediable_id', 26)->nullable();
            $table->string('collection')->default('default');
            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('filename');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('user_id', 26)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['mediable_type', 'mediable_id']);
            $table->index('collection');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
