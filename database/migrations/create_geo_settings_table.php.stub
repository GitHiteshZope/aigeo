<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('geo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('geo_profiles', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->unsignedTinyInteger('score')->default(0);
            $table->json('audit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geo_settings');
        Schema::dropIfExists('geo_profiles');
    }
};
