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
        Schema::create('shortened_urls', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('shortened_url')->unique();
            $table->timestamp('last_used')->nullable()->comment('Specifies when the shorted_url was last used inn any way');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shorted_urls');
    }
};
