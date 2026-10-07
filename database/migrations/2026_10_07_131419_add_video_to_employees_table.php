<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('video_title')->nullable()->after('photo');
            $table->string('video_url')->nullable()->after('video_title');
            $table->string('video_cover')->nullable()->after('video_url');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['video_title', 'video_url', 'video_cover']);
        });
    }
};
